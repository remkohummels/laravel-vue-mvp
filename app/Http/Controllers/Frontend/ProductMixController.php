<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ProductMix;
use App\Models\ProductMix\Modifier as ProductMixModifier;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductMixController extends Controller
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
     * Get the product-mix loading data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo() {
        // Load the data
        $productMix = $this->loadData();

        return response()->json([
                'productMixRequiredList' => $productMix['required']->values()->all(),
                'productMixLimitedList' => $productMix['limited']->values()->all(),
                'productMixDefaultList' => $productMix['default']->all(),
                'productMixModifier' => $productMix['modifier']
        ]);
    }

    /**
     * Update the unit ct. of the product-mix table.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        // Get the request data array
        $requestData = $request->all();

        // Update the unit ct. value indicated by rowPk & fieldName
        $productMix = ProductMix::find($requestData['rowPk']);
        $productMix[$requestData['fieldName']] = $requestData['unitCount'];
        $productMix->save();

        // Create or Update the product_mix_modifier with an editor name
        $productMixModifier = $productMix->restaurant()->productMixModifier();
        if ($productMixModifier) {
            $productMixModifier->product_mix_id = $productMix->id;
            $productMixModifier->name = 'MOD';
            $productMixModifier->save();
        } else {
            $newModifier = new ProductMixModifier;
            $newModifier->product_mix_id = $productMix->id;
            $newModifier->restaurant_id = $productMix->restaurant_id;
            $newModifier->name = 'MOD';
            $newModifier->save();

            // Replace the null modifier with a new one
            $productMixModifier = $newModifier;
        }

        return response()->json([
                'productMixModifier' => $productMixModifier
        ]);
    }

    /**
     * Export the pdf of product-mix content.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportPDF() {
        $restaurant = Auth::guard('restaurant')->user();

        // Load the data
        $productMix = $this->loadData();

        $data = [
            'productMixRequiredList' => $productMix['required']->values()->all(),
            'productMixLimitedList' => $productMix['limited']->values()->all()
        ];

        /* Test the blade template view */
        //return view('pages.frontend.pdf.product_mix_table', $data);

        // Download the PDF file
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pages.frontend.pdf.product_mix_table', $data);
        $pdfFileName = 'Rest#' . $restaurant->restaurant_id . ' - Product Mix.pdf';
        $pdf->save($pdfFileName);

        return response()->json([
                'pdfFileName' => $pdfFileName
        ]);
    }

    public function downloadFile($fileType = null) {
        $restaurant = Auth::guard('restaurant')->user();

        $fileName = 'fake';
        if ($fileType == 'pdf') {
            $fileName = 'Rest#' . $restaurant->restaurant_id . ' - Product Mix.pdf';
        } else if ($fileType == 'excel') {
            $fileName = 'Rest#' . $restaurant->restaurant_id . ' - Product Mix.xls';
        }

        if (file_exists(public_path($fileName))) {
            return response()->download($fileName);
        }

        return response()->json([
                'error' => 'Download is failed.'
        ]);
    }

    /**
     * Export the excel of product-mix content.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel() {
        // Load the data
        $productMix = $this->loadData();

        // Initialize the array which will be passed into the Excel generator
        $productMixRequiredArr = [];
        $productMixLimitedArr = [];

        // Filter the collection and convert them into an array.
        foreach ($productMix['required'] as $row) {
            $filteredRowArr = [
                    $row['menu_item_name'],
                    $row['unit'],
                    $row['monday'],
                    $row['tuesday'],
                    $row['wednesday'],
                    $row['thursday'],
                    $row['friday'],
                    $row['saturday'],
                    $row['sunday'],
            ];
            $productMixRequiredArr[] = $filteredRowArr;
        }

        foreach ($productMix['limited'] as $row) {
            $filteredRowArr = [
                    $row['menu_item_name'],
                    $row['unit'],
                    $row['monday'],
                    $row['tuesday'],
                    $row['wednesday'],
                    $row['thursday'],
                    $row['friday'],
                    $row['saturday'],
                    $row['sunday'],
            ];
            $productMixLimitedArr[] = $filteredRowArr;
        }

        // Generate and return the spreadsheet
        $excel = Excel::create('product_mix', function($excel) use ($productMixRequiredArr, $productMixLimitedArr) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Product Mix Table');
            $excel->setCreator('Support Team')->setCompany('Cajun Operating Company');
            $excel->setDescription('product-mix file');

            // Build the spreadsheet, passing in the product-mix array
            $excel->sheet('sheet1', function($sheet) use ($productMixRequiredArr, $productMixLimitedArr) {

                // Customize the sheet style
                $sheet->setAutoSize(array(
                        'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'
                ));

                $sheet->setAllBorders('thin');

                $sheet->mergeCells('A1:J1')
                    ->mergeCells('A2:A3')
                    ->mergeCells('B2:B3')
                    ->mergeCells('C2:C3')
                    ->mergeCells('D2:J2');

                $sheet->setCellValue('A1', 'Product Mix Table')
                    ->setCellValue('B2', 'Product')
                    ->setCellValue('C2', 'Unit Ct.')
                    ->setCellValue('D2', 'Avg. Pieces Sold On Any Given...')
                    ->setCellValue('D3', 'Monday')
                    ->setCellValue('E3', 'Tuesday')
                    ->setCellValue('F3', 'Wednesday')
                    ->setCellValue('G3', 'Thursday')
                    ->setCellValue('H3', 'Friday')
                    ->setCellValue('I3', 'Saturday')
                    ->setCellValue('J3', 'Sunday');
                $sheet->setWidth('A', 20);
                $sheet->setHeight(1, 50);
                $sheet->setHeight(2, 30);

                if (count($productMixRequiredArr) > 0) {
                    $sheet->mergeCells('A4' . ':' . 'A' . (count($productMixRequiredArr) + 3));
                    $sheet->setCellValue('A4', 'Regular Offer');
                    $sheet->cell('A4', function($cell) {

                        // Set vertical alignment to middle
                        $cell->setValignment('center');
                        $cell->setAlignment('center');
                        $cell->setBackground('#cccccc');
                        $cell->setFontWeight('bold');
                        $cell->setFontColor('#a94442');

                    });
                }

                if (count($productMixLimitedArr) > 0) {
                    $sheet->mergeCells('A' . (count($productMixRequiredArr) + 4) . ':' . 'A' . (count($productMixRequiredArr) + count($productMixLimitedArr) + 3));
                    $sheet->setCellValue('A' . (count($productMixRequiredArr) + 4), 'Limited Time Offer');
                    $sheet->cell('A' . (count($productMixRequiredArr) + 4), function($cell) {

                        // Set vertical alignment to middle
                        $cell->setValignment('center');
                        $cell->setAlignment('center');
                        $cell->setBackground('#cccccc');
                        $cell->setFontWeight('bold');
                        $cell->setFontColor('#a94442');

                    });
                }

                // Assign the content values into a sheet from an array
                $sheet->fromArray(array_merge($productMixRequiredArr, $productMixLimitedArr), null, 'B4', false, false);

                $sheet->cell('A1', function($cell) {

                    // Set vertical alignment to middle
                    $cell->setValignment('center');
                    $cell->setAlignment('center');
                    $cell->setFontWeight('bold');
                    $cell->setFontSize(16);
                    $cell->setFontColor('#004fa5');

                });

                $sheet->cell(('B2:C2'), function($cells) {

                    $cells->setValignment('center');
                    $cells->setBackground('#cccccc');
                    $cells->setFontWeight('bold');

                });

                $sheet->cell('D2', function($cell) {

                    $cell->setValignment('center');
                    $cell->setBackground('#cccccc');
                    $cell->setFontWeight('bold');

                });

                $sheet->cell('D3:J3', function($cells) {

                    // Set light-brown background
                    $cells->setBackground('#ddcba1');

                });

                $sheet->cell('B4' . ':' . 'C' . (count($productMixRequiredArr) + count($productMixLimitedArr) + 3), function($cells) {

                    // Set light-brown background
                    $cells->setBackground('#ddcba1');

                });

                $sheet->cell('D2' . ':'. 'J' . (count($productMixRequiredArr) + count($productMixLimitedArr) + 3), function($cells) {

                    // Set alignment to center
                    $cells->setAlignment('center');

                });
            });

        });

        return $excel->download('xls');
    }

    /**
     * Load the data from product_mix + menu_items table.
     *
     * @return \Illuminate\Http\Response
     */
    private function loadData() {
        $restaurant = Auth::guard('restaurant')->user();
        $productMixList = $restaurant->productMixList();
        $productMixDefaultList = $restaurant->productMixDefaultList();
        $productMixModifier = $restaurant->productMixModifier();

        $productMixRequiredCollection = collect();
        $productMixLimitedCollection = collect();

        // Keys the productMixDefault collection by the 'menu_item_id' key
        $productMixDefaultCollection = $productMixDefaultList->keyBy('menu_item_id');

        // Update the productMixCollection with the details of menuItems
        foreach ($productMixList as $key => $row) {
            $menuItem = $row->menuItem();
            $collection = collect($row);
            $collection->put('menu_item_name', $menuItem->name);
            $collection->put('menu_item_required', $menuItem->required);
            if ($menuItem->required == 1)
                $productMixRequiredCollection->push($collection);
            else
                $productMixLimitedCollection->push($collection);
        }

        $data = [
            'required' => $productMixRequiredCollection,
            'limited' => $productMixLimitedCollection,
            'default' => $productMixDefaultCollection,
            'modifier' => $productMixModifier
        ];

        return $data;
    }
}
