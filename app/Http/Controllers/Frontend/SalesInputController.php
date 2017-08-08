<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesInput;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SalesInputController extends Controller
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
    public function index()
    {
        return view('pages.frontend.dashboard');
    }

    /**
     * Get the sales input info.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo() {
        // Load the data
        $salesInput = $this->loadData();

        return response()->json([
            'salesInputList' => $salesInput->all()
        ]);
    }

    // update sales input by date
    public function update(Request $request) {
        $requestData = $request->all();
        $requestData['restaurant_id'] = Auth::guard('restaurant')->user()->restaurant_id;

        if (isset($requestData['rowPk']))
            $salesInputExist = SalesInput::find($requestData['rowPk']);

        if (isset($salesInputExist)) {
            $salesInputExist->update($requestData);
        } else {
            $salesInputExist = SalesInput::create($requestData);
        }

        return response()->json(['success' => true, 'id' => $salesInputExist['id']]);
    }

    /**
     * Export the pdf of sales input content.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportPDF() {
        // Load the data
        $salesInput = $this->loadData();

        $data = [
            'salesInputList' => $salesInput->all()
        ];

        /* Test the blade template view */
        //return view('pages.frontend.pdf.sales_input_table', $data);

        // Download the PDF file
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pages.frontend.pdf.sales_input_table', $data);
        //return $pdf->stream(); /* test the PDF view */
        return $pdf->download('sales_input.pdf');
    }

    /**
     * Export the excel of product-mix content.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel() {
        // Load the data
        $salesInput = $this->loadData();
        // Filter the collection and convert them into an array.
        for ($count = 1; $count < 15; $count++) {
            if (!empty($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))
            {
                $filteredRowArr = [
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0700'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0800'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0900'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1000'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1100'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1200'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1300'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1400'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1500'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1600'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1700'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1800'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'1900'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'2000'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'2100'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'2200'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'2300'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'2400'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0100'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0200'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0300'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0400'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0500'},
                    '$'.json_decode(json_encode($salesInput[Carbon::now()->subDays($count)->format('Y-m-d')]))->{'0600'},
                ];
            } else {
                $filteredRowArr = [
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                    'Missed',
                ];
            }
            $salesInputArr[$count] = $filteredRowArr;
        }

        // Generate and return the spreadsheet
        $excel = Excel::create('sales_input', function($excel) use ($salesInputArr, $salesInput) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Sales Input Table');
            $excel->setCreator('Support Team')->setCompany('Cajun Operating Company');
            $excel->setDescription('sales input file');

            // Build the spreadsheet, passing in the sales input array
            $excel->sheet('sheet1', function($sheet) use ($salesInputArr, $salesInput) {

                // Customize the sheet style
                $sheet->setAutoSize(array(
                    'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
                    'V', 'W', 'X', 'Y'
                ));

                $sheet->setAllBorders('thin');

                $sheet->mergeCells('A1:H1');

                $sheet->setCellValue('A1', 'Sales Input Table');
                $restaurant_id = Auth::guard('restaurant')->user()->restaurant_id;
                $sheet->setCellValue('A2', 'Restaurant '.$restaurant_id);

                for($i = 1; $i < 15; $i++) {
                    $sheet->setCellValue('A'.($i + 2), $salesInputArr[$i][0] != 'Missed' ?
                        $salesInput[Carbon::now()->subDays($i)->format('Y-m-d')]['ignore'] == 1 ?
                        Carbon::now()->subDays($i)->format('m/d/Y').'(Ignored)' : Carbon::now()->subDays($i)->format('m/d/Y')
                        : Carbon::now()->subDays($i)->format('m/d/Y').'(Missed)');
                    if ($salesInputArr[$i][0] != 'Missed') {
                        if ($salesInput[Carbon::now()->subDays($i)->format('Y-m-d')]['ignore'] == 1) {
                            $sheet->cell('A'.($i + 2), function($cell) {

                                $cell->setBackground('#cccccc');
                                $cell->setFontWeight('bold');
                            });
                        } else {
                            $sheet->cell('A'.($i + 2), function($cell) {

                                $cell->setBackground('#ffffff');
                                $cell->setFontWeight('bold');
                            });
                        }
                    } else {
                        $sheet->cell('A'.($i + 2), function($cell) {

                            $cell->setBackground('#ddcba1');
                            $cell->setFontWeight('bold');
                        });
                    }
                }
                for ($index = 0; $index < 24; $index++) {
                    $str = '';
                    if (($index < 7) || ($index > 18)) $str = (($index + 6) % 24) . ':00 - ';
                    else $str = ($index - 6) . ':00 - ';
                    if (($index < 6) || ($index > 17)) $str .= (($index + 7) % 24) . ':00 ';
                    else $str .= ($index - 5) . ':00 ';
                    if (($index < 6) || ($index > 17)) {
                        if ($index == 5) $str .= 'Noon';
                        else $str .= 'AM';
                    } else $str .= 'PM';
                    $sheet->setCellValue(chr($index + 66) . '2', $str);
                }

                $sheet->setWidth('A', 25);
                $sheet->setHeight(1, 50);
                $sheet->setHeight(2, 30);

                // Assign the content values into a sheet from an array
                $sheet->fromArray($salesInputArr, null, 'B3', false, false);

                $sheet->cell('A1', function($cell) {

                    // Set vertical alignment to middle
                    $cell->setValignment('center');
                    $cell->setAlignment('center');
                    $cell->setFontWeight('bold');
                    $cell->setFontSize(16);
                    $cell->setFontColor('#004fa5');

                });

                $sheet->cell('A2', function($cell) {

                    $cell->setFontWeight('bold');
                    $cell->setFontSize(14);
                    $cell->setFontColor('#ff0000');
                });

                $sheet->cell('B2:Y2', function($cells) {

                    $cells->setBackground('#ddcba1');
                    $cells->setFontWeight('bold');
                });

                for ($i = 2; $i < 17; $i++) {
                    $sheet->cell('A'.$i.':Y'.$i, function ($cells) {

                        $cells->setValignment('center');
                        $cells->setAlignment('center');
                    });
                }
            });

        });

        return $excel->download('xls');
    }

    /**
     * Load the data from sales_input table.
     *
     * @return \Illuminate\Http\Response
     */
    private function loadData() {
        $restaurant = Auth::guard('restaurant')->user();
        $salesInputList = $restaurant->salesInputList();
        $salesInputCollection = collect();

        // update the salesInputCollection with the salesInput list
        foreach ($salesInputList as $key => $row) {
            $salesInputCollection->put(date('Y-m-d', strtotime($row['date'])), $row);
        }

        return $salesInputCollection;
    }

    /**
     * get sales alert info
     */
    public function getSalesAlertInfo($currentDate) {
        $restaurant = Auth::guard('restaurant')->user();

        $start = Carbon::parse($currentDate)->subDays(14);

        $tmpSql = '';
        for ($i = 0 ; $i <= 14; $i++) {
            $date = $start->copy()->addDays($i)->toDateString();
            if ($i == 0)
                $tmpSql = "SELECT dummy.date, sales_input.id FROM ( SELECT '". $date . "' AS date";
            else
                $tmpSql .= " UNION SELECT '" . $date . "'";
        }
        $tmpSql .= ") dummy left join (select * from sales_input ";
        $tmpSql .= " where sales_input.date >= '" . Carbon::parse($currentDate)->subDays(14)->toDateString() . "'";
        $tmpSql .= " and sales_input.date <= '" . $currentDate . "'";
        $tmpSql .= " and sales_input.restaurant_id = " . $restaurant->id;
        $tmpSql .= ") sales_input on dummy.date = sales_input.date group by dummy.date order by dummy.date";


        $salesInputs = DB::select($tmpSql);
        $missingDaysCount = 15 - SalesInput::where('date', '>=', Carbon::parse($currentDate)->subDays(14)->toDateString())
                                    ->where('date', '<=', $currentDate)
                                    ->where('restaurant_id', '=', $restaurant->id)
                                    ->count();


        return response()->json([
            'salesInputs' => $salesInputs,
            'missingDaysCount' => $missingDaysCount
        ]);
    }
}
