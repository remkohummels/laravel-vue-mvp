<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ProductProjection;
use App\Models\ProductProjection\Schedule;
use App\Models\ProductProjection\HoursTemplate;
use App\Models\SalesInput;
use App\Models\ProductProjection\Override;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ErrorLogs as ErrorLogDB;
use Illuminate\Support\Facades\Auth;


class ProductProjectionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.restaurant');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('pages.frontend.dashboard');
    }

    public function getInfo(Request $request){
        /*
         * Average Sales Per Hour
         * - Find day of the week
         *      - Select 6 random rows
         *          - For each time span (10:00 - 11:00, 11:00 - 12:00, etc)
         *              - Remove largest and smallest values
         *              - Add values and divide by 4
         *                  - these are average sales per hour
         *
         *
         * Daily Average Sales Total
         * - total of average sales
         *
         * Product Per Dollar
         * - Average Pieces Sold per Product (divided by) Daily Average Sales Total
         *
         * Product Projection values
         * - Foreach Product
         *      - Get the 'Product Per Dollar'
         *      - Foreach hour of the day
         *          - Divide the Average Sales Per Hour by Product Per Dollar
         *              - total is the number of product for that hour
         *
         * Example:
         *      x = Average Sales Per Hour / ( Average Pieces Sold per Product / Daily Average Sales Total )
         *
         */

        $restaurant = Auth::guard('restaurant')->user();
        $restaurant_id = $restaurant['restaurant_id'];

        $requestData = $request->all();

        $product_mix = $this->getProductMix($restaurant_id);
        if(count($product_mix) == 0){
            return response("Oops, we don’t have Products associated to your restaurant.\n Before you can use the Product Projection we need to get some associated. \n This is an administrative feature – please reach out to your Regional Manager, or contact support to let us know.", 401);
        }

        $sales_input = $this->getSalesInput($restaurant_id);

        if(count($sales_input) == 0){
            return response(" Oops, we don’t have any sales history for your restaurant. \n Before you can use the Product Projection, close this window and enter sales for one or more days.", 401);
        }

        // Check if ProductProjection has been created today
        $current_projection = ProductProjection::where('restaurant_id', '=', $restaurant_id)
            ->whereDay('created_at', date('d'))->get()->toArray();

        if ($current_projection) {

            if ($current_projection[0]['opening_mod'] == '') {
                $product_projection['openingMod'] = $requestData['openingMod'];
            } else {
                if ($current_projection[0]['opening_mod'] != $requestData['openingMod'] && $requestData['openingMod'] != '') {
                    $product_projection['openingMod'] = $requestData['openingMod'];
                } else {
                    $product_projection['openingMod'] = $current_projection[0]['opening_mod'];
                }
            }

            if ($current_projection[0]['closing_mod'] == '') {
                $product_projection['closingMod'] = $requestData['closingMod'];
            } else {
                if ($current_projection[0]['closing_mod'] != $requestData['closingMod'] && $requestData['closingMod'] != '') {
                    $product_projection['closingMod'] = $requestData['closingMod'];
                } else {
                    $product_projection['closingMod'] = $current_projection[0]['closing_mod'];
                }
            }

            if ($current_projection[0]['day_expected'] == 0) {
                $expected_total_sales = $requestData['expectedSales'];
            } else {
                if ($current_projection[0]['day_expected'] != $requestData['expectedSales'] && $requestData['expectedSales'] != 0) {
                    $expected_total_sales = $requestData['expectedSales'];
                } else {
                    $expected_total_sales = $current_projection[0]['day_expected'];
                }
            }

        } else {
            $expected_total_sales = $requestData['expectedSales'];
            $product_projection['openingMod'] = $requestData['openingMod'];
            $product_projection['closingMod'] = $requestData['closingMod'];
        }

        $expected_hourly_average_sales = $this->getExpectedSales($sales_input, $expected_total_sales);
        $product_projection['projectedSalesTotal'] = (int)array_sum($this->getAvgSales($sales_input));
        $product_projection['schedule'] = $this->calculateProductProjectionSchedule($product_mix, $expected_hourly_average_sales, $product_projection['projectedSalesTotal']);
        $product_projection['calculator'] = $this->calculator($restaurant_id, $expected_hourly_average_sales);
        $product_projection['expectedSalesTotal'] = $expected_total_sales;

        $this->saveProductProjection($restaurant_id, $product_projection, $expected_total_sales);

        return response()->json([
            'productProjection' => $product_projection
        ]);

    }

    public function saveProductProjection($restaurant_id, $product_projection, $expectedSales){

        $data = array(
            'restaurant_id'                         => $restaurant_id,
            'opening_mod'                           => $product_projection['openingMod'] == null ? '' : $product_projection['openingMod'],
            'closing_mod'                           => $product_projection['closingMod'] == null ? '' : $product_projection['closingMod'],
            'day_projected'                         => $product_projection['projectedSalesTotal'],
            'day_expected'                          => $expectedSales,
            'day_difference'                        => $expectedSales - $product_projection['projectedSalesTotal'],
            'product_projection_hours_template_id'  => 1,
            'created_at'                            => Carbon::now(),
            'updated_at'                            => Carbon::now()
        );

        try{

            $exists = ProductProjection::where('restaurant_id', '=', $restaurant_id )
                ->whereDay('created_at', date('d') )->get()->toArray();

            $create = ProductProjection::updateOrCreate(['id' => $exists ? $exists[0]['id'] : '' ], $data);

            $schedule = array();

            foreach($product_projection['schedule'] as $key => $menu_items){
                if($key != 'projectionTimes'){

                    $row = array(
                        'product_projection_id' => $create->id,
                        'active'                => 1,
                        'menu_item_id'          => $menu_items['info']['menu_item_id'],
                        'created_at'            => Carbon::Now(),
                        'updated_at'            => Carbon::Now()
                    );

                    foreach($menu_items['projection'] as $day_part){
                        foreach ($day_part as $key => $time){
                            $row[$key] = $time;
                        }
                    }
                    $schedule[] = $row;
                }
            }

            foreach($schedule as $row){
                Schedule::updateOrCreate(['product_projection_id' => $create->id,  'menu_item_id' => $row['menu_item_id']], $row);
            }

        } catch(\Illuminate\Database\QueryException $ex){
            ErrorLogDB::create(['function' => 'ProductProjectionController/saveProductProjection', 'error' => 'MESSAGE: Insert ProductProjection ' . $ex->getMessage() . ' 
        
                TRACE: ' . $ex->getTraceAsString()]);
        }
    }

    /**
     * Export the pdf of cooking-schedule table.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportPDF($expectedSales = null, $mod = null,$shift = null) {

        $restaurant = Auth::guard('restaurant')->user();
        $restaurant_id = $restaurant['restaurant_id'];

        $product_mix = $this->getProductMix($restaurant_id);
        $sales_input = $this->getSalesInput($restaurant_id);

        $expected_total_sales = $expectedSales;
        $expected_hourly_average_sales = $this->getExpectedSales($sales_input, $expected_total_sales);

        $product_projection['projectedSalesTotal'] = (int)array_sum($this->getAvgSales($sales_input));

        // Load the scheduled data
        $scheduledData = $this->calculateProductProjectionSchedule($product_mix, $expected_hourly_average_sales, $product_projection['projectedSalesTotal'], $shift);

        // Eliminate the 'projectionTimes' part from the scheduledData array
        $filterSchedule = collect($scheduledData)->forget('projectionTimes')->values()->all();

        // Extract the menu_item_name array from Schedule
        $menuNameList = collect(collect($filterSchedule)->pluck('info')->all())->pluck('name')->all();

        // Extract the day_parts collection from schedule
        $dayPartCollection = collect($filterSchedule)->pluck('projection');

        // Create $dayPartList array (Key: sheet, Value: (Key: day_parts, Value: array) )
        $dayPartList = array( array() );
        $dayPartPageCount = 0;

        foreach ($dayPartCollection->first() as $key => $value) {
            $timeUnitCollection = $dayPartCollection->pluck($key);

            // Create the new array (Key: time, Value: unit)
            foreach ($timeUnitCollection->first() as $time => $unit) {

                if(count(collect($dayPartList[$dayPartPageCount])->flatten(1) ) <= 9){
                    $dayPartList[$dayPartPageCount][$key][$time] = $timeUnitCollection->pluck($time)->all();
                }else{
                    $dayPartPageCount++;
                    $dayPartList[$dayPartPageCount][$key][$time] = $timeUnitCollection->pluck($time)->all();
                }
            }
        }

        $data = [
            'menuNameList'  => $menuNameList,
            'dayPartList'   => $dayPartList,
            'mod'           => $mod,
            'shift'         => $shift
        ];

        /* Test the blade template view */
//         return view('pages.frontend.pdf.cooking_schedule_table', $data);

        // Download the PDF file
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pages.frontend.pdf.cooking_schedule_table', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('cooking_schedule.pdf');
    }

    public function override(Request $request){
        $restaurant = Auth::guard('restaurant')->user();
        $requestData = $request->all();

        $data = array(
            'restaurant_id' => $restaurant['restaurant_id'],
            'time'          => $requestData['time'],
            'value'         => $requestData['value'],
            'frequency'     => $requestData['frequency'],
            'menu_item_id'  => $requestData['product_id'],
            'date'          => date('Y-m-d')
        );

        $menu_items_mix_max = $this->getMenuItemsMinMax($requestData['product_id'],  $requestData['time']);

        if($menu_items_mix_max) { // Product Has Min and Max values
            if (str_replace(":", "", $menu_items_mix_max[0]->time) == $requestData['time'] . '00') {

                if ($requestData['value'] < $menu_items_mix_max[0]->min) {

//                return response()->json(['success' => false, 'message' => 'The mimimum for this product is '.$menu_items_mix_max[0]->min]);
//                return response()->setStatusCode(400, 'The mimimum for this product is'.$menu_items_mix_max[0]->min);
                    return response('The mimimum for this product is ' . $menu_items_mix_max[0]->min, 401);

                } else if ($requestData['value'] > $menu_items_mix_max[0]->max) {

                    return response('The maximum for this product is ' . $menu_items_mix_max[0]->max, 401);

                } else {
                    Override::updateOrCreate(['restaurant_id' => $restaurant['id'], 'time' => $requestData['time'], 'date' => date('Y-m-d'), 'menu_item_id' => $requestData['product_id']], $data);
                    return response()->json(['success' => true, 'message' => '']);
                }
            }
        }else{
            Override::updateOrCreate(['restaurant_id' => $restaurant['id'], 'time' => $requestData['time'], 'date' => date('Y-m-d'), 'menu_item_id' => $requestData['product_id']], $data);
            return response()->json(['success' => true, 'message' => '']);

        }
    }

    public function calculator($restaurant_id, $sales_input){

        $expected_sales = array();

        foreach($sales_input as $time => $value){
            $daypart = $this->checkDayPart($restaurant_id, $time, strtolower(Carbon::parse(Carbon::now())->format('l')) );
            $expected_sales[$daypart][] = $value;
        }

        foreach($expected_sales as $part => $array){
            unset($expected_sales[$part]);
            $expected_sales[$part]['value'] = array_sum($array);

            $actual_sales[$part]['value'] = 0;
            $difference_sales[$part]['value'] = 0;
        }

        return array('expected' => $expected_sales, 'actual' => $actual_sales, 'difference' => $difference_sales);
    }

    public function getDayParts($restaurant_id){

        return DB::table('restaurant_hours')
            ->select('day_part','start_time','end_time')
            ->where('restaurant_id', '=', $restaurant_id)
            ->where('dayofweek','=',strtolower(Carbon::parse(Carbon::now())->format('l')))
            ->get()
            ->toArray();
    }

    // Amount of Product Sold day of the week for the restaurant
    public function getProductMix($restaurant_id){
        // GET ProductMix
        $product_mix = DB::table('product_mix')
            ->join('menu_items', 'product_mix.menu_item_id', '=', 'menu_items.id')
            ->select('product_mix.*', 'menu_items.name')
            ->where('restaurant_id', '=', $restaurant_id)
            ->orderby('id','ASC')
            ->get()
            ->toArray();
        return $product_mix;

    }
    public function getSalesInput($restaurant_id){

        // Get Last 6 rows from SalesInput by $dayoftheweek
        $sales_input = DB::table('sales_input')
            ->select('0100','0200','0300','0400','0500','0600','0700','0800','0900','1000','1100','1200',
                '1300','1400','1500','1600','1700','1800','1900','2000','2100','2200','2300','2400')
            ->where('restaurant_id', '=', $restaurant_id)
            ->where('ignore', '=', 0)
            ->where(DB::raw("DAYOFWEEK(`date`)"), DB::raw("DAYOFWEEK('".Carbon::now()."')"))
            ->limit(6)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        if(count($sales_input) == 0 ){ // zero data for that day of the week

            $sales_input = DB::table('sales_input')
                ->select('0100','0200','0300','0400','0500','0600','0700','0800','0900','1000','1100','1200',
                    '1300','1400','1500','1600','1700','1800','1900','2000','2100','2200','2300','2400')
                ->where('restaurant_id', '=', $restaurant_id)
                ->where('ignore', '=', 0)
                ->limit(6)
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();

            if(count($sales_input) == 0 ) { // zero data in general
                ErrorLogDB::create(['function' => 'ProductProjectionController/getSalesInput', 'error' => 'MESSAGE: No Sales Input Data for Rest#'.$restaurant_id ]);
            }
        }
        return $sales_input;
    }

    // Average Sales Amount Per Hour for the restaurant
    public function getAvgSales($sales_input){

        // Get columns in product_projection_schedule table
        $keys = DB::getSchemaBuilder()->getColumnListing('product_projection_schedule');

        // Remove column names that aren't numeric
        foreach ($keys as $k => $v){
            if(!is_numeric($v)){
                unset($keys[$k]);
            }
        }

        // Create array with hours as keys and arrays as values
        $projected_hourly_average_sales = array_fill_keys($keys, array());

        // Loop through and add values to an array for each hour of the day
        foreach($sales_input as $row){
            foreach($row as $key => $hour){
                $projected_hourly_average_sales[$key][] = $hour;
            }
        }

        // Loop through arrays, get SUM of values, subtract Min & Max values, divide by 4 to get Average Sales per Hour
        foreach($projected_hourly_average_sales as $hour => $values){
            if(!empty($values)){

                if(count($values) > 3){
                    $avg = (array_sum($values) - (max($values) + min($values))) / (count($values) - 2);
                }else{
                    $avg = array_sum($values) / count($values);
                }

                $projected_hourly_average_sales[$hour] = round($avg);
            }
        }

        return $projected_hourly_average_sales;
    }

    public function getExpectedSales($sales_input, $expected_total)
    {

        $projected_hourly_sales = $this->getAvgSales($sales_input);

        if ($expected_total != 0) {
            $projected_sales_total = array_sum($projected_hourly_sales);

            foreach ($projected_hourly_sales as $hour => $hourly_sold) {
                if (!is_array($hourly_sold)) {
                    $projected_hourly_sales[$hour] = round(($hourly_sold * $expected_total) / $projected_sales_total);
                }
            }
        }

        return $projected_hourly_sales;
    }

    public function calculateProductProjectionSchedule($product_mix, $projected_hourly_average_sales, $projectedSalesTotal, $shift = null ){

        // get day of the week from date
        $dayoftheweek = strtolower(Carbon::parse(Carbon::now())->format('l'));

        // Set ProductProjects array
        $product_projection = array();
        foreach ($product_mix as $product) {

            // Get Average Units Sold for Current day.
            $product_sold = (array)$product->$dayoftheweek;

            // Remove array
            $product_sold = $product_sold[0];

            // Create $half_hour variable to track the previous key the following foreach loop
            $half_hour = '';

            // Set Return array
            $return['info'] = array(
                'restaurant_id'    => $product->restaurant_id,
                'active'           => $product->active,
                'menu_item_id'     => $product->menu_item_id,
                'name'             => $product->name,
                'unit'             => $product->unit,
                'day'              => $dayoftheweek
            );

            $projection_times = array();

            // Loop through $projected_hourly_average_sales. Calculate ProductProjection for each hour
            foreach ($projected_hourly_average_sales as $hour => $hourly_sales_amount) {

                if (!empty($hourly_sales_amount)) {
                    // calculate the Product Per Dollar value
                    $projection = $this->calculateProductPerDollar($hourly_sales_amount, $product_sold, $projectedSalesTotal );

                    // check if product projection value is between the min and max setting and Set previous half and current hour to half of the projection value

                    $half_hour_projection = $this->modifyProjection($half_hour, ($projection / 2),$product->menu_item_id);
                    $hour_projection = $this->modifyProjection($hour, ($projection / 2),$product->menu_item_id);

                    $half_hour_daypart = $this->checkDayPart($product->restaurant_id, $half_hour);
                    $hour_daypart = $this->checkDayPart($product->restaurant_id, $hour);


                    $return['projection'][$half_hour_daypart][$half_hour] = $half_hour_projection;
                    $return['projection'][$hour_daypart][$hour] = $hour_projection;

                    $projection_times[$half_hour_daypart][] = $half_hour;
                    $projection_times[$hour_daypart][] = $hour;

                } else {
                    // if $hourly_sales_amount array is empty, set $half_hour to $hour ( which we know will be a half hour increment )
                    $half_hour = $hour;
                }
            }

            if(!is_null($shift)){
                $shift_parts = $this->getDayPartShift($product->restaurant_id,$shift == 'Open' ? 'opening' : 'closing');

                foreach($shift_parts as $shift_part){
                    unset($return['projection'][$shift_part->day_part]);
                    unset($projection_times[$shift_part->day_part]);
                }
            }

            $product_projection[$product->name] = $return;
            $product_projection['projectionTimes'] = $projection_times;
        }

        return $product_projection;
    }

    public function getDayPartShift($rest_id, $shift){

        $dayparts = DB::table('restaurants')
            ->select('day_part')
            ->join('day_parts', 'restaurants.hours_template_id', '=', 'day_parts.hours_template_id')
            ->where('restaurant_id', '=', $rest_id)
            ->where('dayofweek','=', strtolower(Carbon::parse( Carbon::now() )->format('l')) )
            ->where('shift','!=', $shift)
            ->get()
            ->toArray();

        return $dayparts;
    }

    public function checkDayPart($rest_id, $time){

        $time = $time.'00';

        $between = DB::table('restaurant_hours')
            ->select('day_part')
            ->where('restaurant_id', '=', $rest_id)
            ->where('dayofweek','=', strtolower(Carbon::parse( Carbon::now() )->format('l')) )
            ->where('start_time','<=', $time)
            ->where('end_time','>=', $time)
            ->orderBy('day_part_order','DESC')
            ->limit(1)
            ->get()
            ->toArray();

        if(count($between) > 0){
            return $between[0]->day_part;
        }else{

            $before = DB::table('restaurant_hours')
                ->select('day_part')
                ->where('restaurant_id', '=', $rest_id)
                ->where('dayofweek','=', strtolower( Carbon::parse(Carbon::now() )->format('l')) )
                ->where('start_time','>=', $time)
                ->orderBy('day_part_order','ASC')
                ->limit(1)
                ->get()
                ->toArray();

            if(count($before) > 0) {
                return $before[0]->day_part;
            }else{

                $after = DB::table('restaurant_hours')
                    ->select('day_part')
                    ->where('restaurant_id', '=', $rest_id)
                    ->where('dayofweek','=', strtolower(Carbon::parse(Carbon::now())->format('l')) )
                    ->where('end_time','<=', $time)
                    ->orderBy('day_part_order','DESC')
                    ->limit(1)
                    ->get()
                    ->toArray();
                if(count($after) > 0){
                    return $after[0]->day_part;
                }else{
                    ErrorLogDB::create(['function' => 'ProductProjectionController/checkDayPart', 'error' => 'MESSAGE: No DayParts for Rest#'.$rest_id ]);
                }

            }
        }
    }

    public function calculateProductPerDollar($hourly_sales_amount, $product_sold, $projected_hourly_average_sales){
        // Divide $hourly_sales_amount value by $product_sold divided by sum of $projected_hourly_average_sales
        return ($product_sold / $projected_hourly_average_sales ) * $hourly_sales_amount;
    }

    // Gets Min and Max values for a Menu Item
    public function getMenuItemsMinMax($menu_item_id, $time){

        $time = $time.'00';

        $min_max = DB::table('menu_items_min_max')
            ->select('*')
            ->where('menu_item_id', '=', $menu_item_id)
            ->where('time', '=', $time)
            ->latest()
            ->get()
            ->toArray();

        return $min_max;
    }

    //
    public function modifyProjection($time, $projection, $menu_item_id){

        $menu_items_mix_max = $this->getMenuItemsMinMax($menu_item_id, $time);
        $override = $this->checkOverride($menu_item_id, $time);

        if($menu_items_mix_max) {

            $projection = $override ? $override[0]['value'] : $projection;

            $minmax_projection = $this->checkMenuItemsMinMax($menu_items_mix_max, $time, $projection);

            if (!is_null($minmax_projection) ) {
                return $override ? array($minmax_projection) : round($minmax_projection);

            } else {
                return round($projection);
            }

        }else{

            return $override ? array($override[0]['value']) : round($projection);
        }
    }

    public function checkOverride($menu_item_id, $time){
        $restaurant = Auth::guard('restaurant')->user();

        $override = Override::where(['restaurant_id' => $restaurant['restaurant_id'], 'menu_item_id' => $menu_item_id, 'time' => $time ])->get()->toArray();

        if($override){
            if($override[0]['frequency'] == 1){
                if($override[0]['date'] == date('Y-m-d' )){
                    return $override;
                }
            }else if($override[0]['frequency'] == 2){
                if(Carbon::parse($override[0]['date'])->dayOfWeek == Carbon::now()->dayOfWeek){
                    return $override;
                }
            }
        }else{
            return false;
        }
    }

    // Checks the Product Projection value against the  Min and Max values for the Menu Item.
    public function checkMenuItemsMinMax($menu_items_mix_max, $time, $projection){

        $time = $time.'00';

        if(str_replace(":","",$menu_items_mix_max[0]->time) == $time){

            if($menu_items_mix_max[0]->min > $menu_items_mix_max[0]->max){
                    return $projection;
            }else if( $projection < $menu_items_mix_max[0]->min ){
                    return $menu_items_mix_max[0]->min;
            }else if ( $projection > $menu_items_mix_max[0]->max ){
                    return $menu_items_mix_max[0]->max;
            }else{
                    return $projection;
            }
        }
    }
}

