<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductMix;
use App\Models\ProductMixDefault;
use App\Models\Restaurant;
use App\Models\Restaurant\Hours;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\ErrorLogs;
use Illuminate\Support\Facades\Storage;
//use Response;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Settings;
use Illuminate\Database\QueryException;
use App\Models\ErrorLogs as ErrorLogDB;
use App\Models\SalesInput;
use Carbon\Carbon;

class ImportDataController extends Controller
{
    public static function type($sheet)
    {
        $restaurants = array();
        $restaurantDataFiles = Storage::disk('local')->allFiles('restaurant_data');

        foreach ($restaurantDataFiles as $dataFile) {
            if (stristr($dataFile, "Rest Data Format Rest#") !== FALSE) {
                preg_match('~#(.*?).xlsx~', $dataFile, $fileName);
                preg_match('!\d+!', $dataFile, $restaurantNumber);
                $restaurants[$restaurantNumber[0]] = $fileName[1];
            }
        };

        //Set phpzip class for required Excel
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::ZIPARCHIVE);

        foreach ($restaurants as $restNum => $restaurant) {
            if ($sheet == "menumix") {
                //load the data from $file.
                $reader = Excel::selectSheetsByIndex(1)->load('storage/app/' . 'restaurant_data/Rest Data Format Rest#' . $restaurant . '.xlsx', function ($reader) {});

                $reader->formatDates(true);
                $data = $reader->noHeading()->skipRows(2)->takeColumns(10)->get()->toArray();

                $headers = array(
                    'SKU',
                    'product',
                    'unit',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday'
                );

                $products = array(
                    1 => 'DarOr',
                    2 => 'WhiOr',
                    3 => 'DarSp',
                    4 => 'WhiSp',
                    5 => 'TenOr',
                    6 => 'TenSp',
                    7 => 'Bisc',
                    8 => 'OCH',
                    9 => 'SCH',
                    10 => 'OF',
                    11 => 'SF'
                );

                foreach($data as $row){
                    //create an array of the $data and set the column headers as the keys and add it to $filedata
                    $array = array_combine($headers, $row); //reset() removes the outer array from keys;

                    $array['restaurant_id'] = $restNum;
                    $array['menu_item_id'] = array_search($array['SKU'], $products);
                    $array['active'] = 1;

                    unset($array['SKU']);

                    if(array_key_exists("menu_item_id",$array) && $array['menu_item_id'] != 0 ){
                        self::store('menumix', $array);
                    }
                }
            }
            else if ($sheet == 'sales') {
                //load the data from $file.
                $reader = Excel::selectSheetsByIndex(0)->load('storage/app/' . 'restaurant_data/Rest Data Format Rest#' . $restaurant . '.xlsx', function ($reader) {});

                $headers = array();

                foreach($reader->get()->toArray()[0] as $column => $header){

                    if (is_int($column) && $column != 0) {
                        $headers[] = gmdate("Y-m-d", (int)(($column - 25569) * 86400));
                    } else if ($column === 0){
                        $headers[] = 'delete';
                    } else {
                        $headers[] = 'time';
                    }
                }

                $reader->formatDates(true);
                $data = $reader->skipRows(1)->get()->toArray();

                $sql = array();
                $final = array_fill_keys($headers, array());

                foreach ($data as $row) {

                    //create an array of the $data and set the column headers as the keys and add it to $filedata
                    $row = array_combine($headers, $row);
                    $row['time'] = str_replace(":", "", $row['time']);
                    $row['time'] = (strlen($row['time']) < 4) ? '0'.$row['time'] : $row['time'] ;

                    foreach($row as $k => $r){
                        if(!is_null($r) && $k != 'time'){
                            if($row['time'] == '0000'){
                                $final[$k][2400] = $r;
                            }else{
                                $final[$k][$row['time']] = $r;
                            }
                            $sql[] = array('date' => $k);
                        }
                    }
                }

                unset($final["time"]);
                unset($final["delete"]);

                self::buildSQLArray('sales',$restNum,$final);
            }
        }

        if ($sheet == 'restaurant_hours') {
            $restaurants = Restaurant::where('restaurant_id', '1')
                                     ->orWhere('restaurant_id', '10202')
                                     ->orWhere('restaurant_id', '10388')
                                     ->orWhere('restaurant_id', '10651')
                                     ->orWhere('restaurant_id', '10776')
                                     ->orWhere('restaurant_id', '10777')
                                     ->orWhere('restaurant_id', '11017')
                                     ->orWhere('restaurant_id', '11019')
                                     ->orWhere('restaurant_id', '11021')
                                     ->orWhere('restaurant_id', '142')
                                     ->orWhere('restaurant_id', '1774')
                                     ->orWhere('restaurant_id', '1830')
                                     ->orWhere('restaurant_id', '2020')
                                     ->orWhere('restaurant_id', '2109')
                                     ->orWhere('restaurant_id', '2115')
                                     ->orWhere('restaurant_id', '215')
                                     ->orWhere('restaurant_id', '457')
                                     ->orWhere('restaurant_id', '3940')
                                     ->orWhere('restaurant_id', '4755')
                                     ->orWhere('restaurant_id', '4921')
                                     ->orWhere('restaurant_id', '5403')
                                     ->orWhere('restaurant_id', '574')
                                     ->orWhere('restaurant_id', '590')
                                     ->orWhere('restaurant_id', '694')
                                     ->orWhere('restaurant_id', '695')
                                     ->orWhere('restaurant_id', '701')
                                     ->orWhere('restaurant_id', '707')
                                     ->orWhere('restaurant_id', '7235')
                                     ->get();
            foreach ($restaurants as $id => $restaurant) {
                $dayPartList = $restaurant->dayPartList();
                $dayPartCollection = collect();
                $collection2 = collect();
                $previousrow2 = null;

                foreach ($dayPartList as $key => $row) {
                    if ($previousrow2['dayofweek'] != $row['dayofweek']) {
                        $collection2 = collect();
                        $previousrow2 = $row;
                    }

                    $collection2->push($row);
                    $dayPartCollection->put($row['dayofweek'], $collection2);

                }

                foreach ($dayPartCollection as $weekday => $data) {
                    foreach ($data as $key => $row)
                    {
                        $statement['restaurant_id'] = $restaurant->restaurant_id;
                        $statement['dayofweek'] = $row['dayofweek'];
                        $statement['day_part'] = $row['day_part'];
                        $statement['day_part_order'] = $row['day_part_order'];
                        $statement['start_time'] = $row['start_time'];
                        $statement['end_time'] = $row['end_time'];

                        self::store($sheet, $statement);
                    }
                }
            }
        }
    }

    protected static function buildSQLArray($type, $restNUm, $dates){
        foreach($dates as $key => $date){
            $statement['restaurant_id'] = $restNUm;
            $statement['date'] = Carbon::createFromFormat('Y-m-d', $key);
            foreach($date as $time => $value){

                $statement[(string)$time] = $value;

            }
            self::store($type,$statement);
        }
    }

    protected static function store($type,$row){
        try {
            if ($type == 'sales') {

                SalesInput::firstOrCreate([ 'restaurant_id' => (string)$row['restaurant_id'],'date' => $row['date']->toDateString() ], $row );

            } else if ($type == 'menumix') {

                ProductMix::firstOrCreate(['restaurant_id' => $row['restaurant_id'], 'menu_item_id' => $row['menu_item_id']], $row );
                ProductMixDefault::firstOrCreate(['restaurant_id' => $row['restaurant_id'], 'menu_item_id' => $row['menu_item_id']], $row );

            } else if ($type == 'restaurant_hours') {
                Hours::firstOrCreate(['restaurant_id' => $row['restaurant_id'], 'dayofweek' => $row['dayofweek'], 'day_part' => $row['day_part']], $row);
            }

            // If there is a Query Error which inserting, run the following
        } catch (\Illuminate\Database\QueryException $ex) {
            // Add the query error to an errorlog table in the DB

            if($type == 'sales'){
                ErrorLogDB::create(['function' => $type.'- Rest#'.$row['restaurant_id'].' Date:'.$row['date']. ': ImportData Controller', 'error' => 'MESSAGE: ' . $ex->getMessage() . '

                TRACE: ' . $ex->getTraceAsString()]);

            }else if($type == 'menumix'){
                ErrorLogDB::create(['function' => $type.'- Rest#'.$row['restaurant_id'].' MenuItem:'.$row['menu_item_id']. ': ImportData Controller', 'error' => 'MESSAGE: ' . $ex->getMessage() . '

                TRACE: ' . $ex->getTraceAsString()]);
            }
        }
    }
}
