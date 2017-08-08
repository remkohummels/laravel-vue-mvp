<?php


namespace App\Http\Controllers\Admin;

use App\ErrorLogs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Settings;
use Illuminate\Database\QueryException;
use App\Models\ErrorLogs as ErrorLogDB;
use App\Models\CompanyLocation;
use App\Models\FranchiseLocation;
use App\Models\InternationalLocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;

class HierarchyReportController extends Controller
{
    public static function __callStatic($method, $args)
    {

    }

    //Download Hierarchy Report file from Churches Server and save it to our server.
    public static function download() {

        //get files from
        $ftpFiles = Storage::disk('hierarchyreport')->allFiles();

        //get file name for Hierarchy Report
        $filename = '';
        foreach ($ftpFiles as $ftpFile) {
            if(stristr( $ftpFile,"Hierarchy Report") !== FALSE){
                $filename = stristr( $ftpFile,"Hierarchy Report");
            }
        }

        // Check if file exists on server
        if(Storage::disk('hierarchyreport')->exists($filename)){
            //FTP into the server and save the file contents to $filecontents
            $filecontent = Storage::disk('hierarchyreport')->get($filename);

            //Create a new file with the $filecontent data and save it to our server.
            Storage::disk('local')->put("HierarchyReport.xlsx", $filecontent);
        }else{
            ErrorLogDB::create(['function'=>'Hierarchy Report Controller: Download()', 'error'=>'MESSAGE: Hierarchy Report Not on server' ]);
        }


        if(Storage::disk('local')->exists("HierarchyReport.xlsx" === FALSE)){

            ErrorLogDB::create(['function'=>'Hierarchy Report Controller: Download()', 'error'=>'MESSAGE: HierarchyReport.xlsx did not save' ]);
        }else{
            return 'true';
        }

    }

    //retrieved the data from the report we saved from the FTP
    protected static function getFileData($sheet){
        //Set phpzip class for required Excel
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::ZIPARCHIVE);

        //file name for Hierarchy Report
        $file = "HierarchyReport.xlsx";

        //load the data from $file.
        $reader = Excel::selectSheets(ucwords($sheet.' report'))->load('storage/app/'.$file, function($reader){});

        // load rows containing data
        $data = $reader->skipRows(2)->noHeading()->ignoreEmpty()->get()->toArray();

        // set keys using the headers of the file
        $headers = $reader->skipRows(1)->takeRows(1)->noHeading()->ignoreEmpty()->get()->toArray();

        //array for file data
        $filedata = array();

        //array for keys
        $keys = array();

        $prev_key = 0;
        foreach(reset($headers) as $k => $header){

            $key = str_replace(array('.', "\n", "\r", "\r\n"), '' ,$header);

            if($prev_key != 0 && $keys[$prev_key] == "Franchise Owner Contact Address"){
                $keys[] = "Franchise Owner Contact Address 2";

            }else{
                $keys[] = $key;
            }
            $prev_key = $k;
        }

        foreach($data as $row){
            //create an array of the $data and set the column headers as the keys and add it to $filedata
            $filedata[] = array_combine($keys, $row); //reset() removes the outer array from keys;
        }

        return $filedata;
    }

    // Added Hierarchy Report Data to the DB
    public static function store(){

        // sheets names
        $sheets = array('company','franchise','international');

        foreach($sheets as $sheet){

            //calls getFileData to get the data from the sheets
            $data = self::getFileData($sheet);

            foreach($data as $row){

                //try to insert data into the DB
                try {
                    //switch which model to call depending on sheet name.
                    switch ($sheet) {
                        case 'company':

                            CompanyLocation::updateOrCreate(['Rest #' => $row['Rest #']], $row );
                            break;

                        case 'franchise':

                            FranchiseLocation::updateOrCreate(['Rest #' => $row['Rest #']], $row);
                            break;

                        case 'international':

                            InternationalLocation::updateOrCreate(['Rest #' => $row['Rest #']], $row);

                            break;
                        default:
                            return "broken";
                    }
                // If there is a Query Error which inserting, run the following
                } catch(\Illuminate\Database\QueryException $ex){
                    // Add the query error to an errorlog table in the DB
                    ErrorLogDB::create(['function'=>$sheet.': Hierarchy Report Controller', 'error'=>'MESSAGE: '.$ex->getMessage().'
                     
                     TRACE: '.$ex->getTraceAsString() ]);
                }
            }
        }
    }
}

