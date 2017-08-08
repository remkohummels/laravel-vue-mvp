<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ErrorLogs;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Settings;
use Illuminate\Database\QueryException;
use App\Models\ErrorLogs as ErrorLogDB;
use App\Models\Smg;


class SMGController extends Controller
{
    public static function download()
    {
        $disk = 'smgdata_dev';
        // Get all the file names from the server
        $ftpFiles = Storage::disk($disk)->files();

        ErrorLogDB::create(['function'=>'SMGController/download', 'error'=>'MESSAGE: '. $disk ]);

        // Loop through file names
        foreach ($ftpFiles as $ftpFile) {

            // find the files needed based on string "CHU_CSI_WEB_Current Period_Chu_CSI_". ( Assuming the customer never changes the naming format )
            if(stristr( $ftpFile,"Chu_CSI_WEB_") !== FALSE ){

                // Switch statement to determine which file to work with
                switch(true){

                    // if the file is "CW"
                    case stristr( $ftpFile,"CW") !== FALSE:
                        //FTP into the server and save the file contents to $filecontents
                        $filecontent = Storage::disk($disk)->get($ftpFile);

                        //Create a new file with the $filecontent data and save it to our server.
                        Storage::disk('local')->put('SMGDATA_CW.csv', $filecontent);

                        break;

                    // if the file is "PW"
                    case stristr( $ftpFile,"PW") !== FALSE:
                        //FTP into the server and save the file contents to $filecontents
                        $filecontent = Storage::disk($disk)->get($ftpFile);

                        //Create a new file with the $filecontent data and save it to our server.
                        Storage::disk('local')->put('SMGDATA_PW.csv', $filecontent);

                        break;

                    // if the file is "System"
                    case stristr( $ftpFile,"System") !== FALSE:
                        //FTP into the server and save the file contents to $filecontents
                        $filecontent = Storage::disk($disk)->get($ftpFile);

                        //Create a new file with the $filecontent data and save it to our server.
                        Storage::disk('local')->put('SMGDATA_System.csv', $filecontent);

                        break;

                    // return 'no files' if there are now files to work with
                    default:
                        ErrorLogDB::create(['function'=>'SMGController/download', 'error'=>'MESSAGE: NO FILES on'. $disk ]);

                }

            }else if(stristr( $ftpFile,"Chu_INT") !== FALSE ){  // INTERNATIONAL SMG DATA

                // Switch statement to determine which file to work with
                switch(true){

                    // if the file is "CW"
                    case stristr( $ftpFile,"CW") !== FALSE:
                        //FTP into the server and save the file contents to $filecontents
                        $filecontent = Storage::disk($disk)->get($ftpFile);

                        //Create a new file with the $filecontent data and save it to our server.
                        Storage::disk('local')->put('SMGDATA_INT_CW.csv', $filecontent);

                        break;

                    // if the file is "PW"
                    case stristr( $ftpFile,"PW") !== FALSE:
                        //FTP into the server and save the file contents to $filecontents
                        $filecontent = Storage::disk($disk)->get($ftpFile);

                        //Create a new file with the $filecontent data and save it to our server.
                        Storage::disk('local')->put('SMGDATA_INT_PW.csv', $filecontent);

                        break;

                    // if the file is "System"
                    case (stristr( $ftpFile,"System") !== FALSE):

                        //FTP into the server and save the file contents to $filecontents
                        $filecontent = Storage::disk($disk)->get($ftpFile);

                        //Create a new file with the $filecontent data and save it to our server.
                        Storage::disk('local')->put('SMGDATA_INT_System.csv', $filecontent);

                        break;

                    // return 'no files' if there are now files to work with
                    default:
                        ErrorLogDB::create(['function'=>'SMGController/download', 'error'=>'MESSAGE: NO FILES on'. $disk ]);
                }
            }
        }

        $files = array(
            'SMGDATA_CW.csv',
            'SMGDATA_PW.csv',
            'SMGDATA_System.csv',
            'SMGDATA_INT_CW.csv',
            'SMGDATA_INT_PW.csv',
            'SMGDATA_INT_System.csv'
        );

        foreach($files as $file) {
            if (Storage::disk('local')->exists($file) === FALSE) {
                ErrorLogDB::create(['function'=>'SMGController/download', 'error'=>'MESSAGE: '. $file .' Does Not Exist']);
            }
        }

        return 'true';

    }

    // Retrieve the data from the report we saved from the FTP
    protected static function getFileData($file)
    {
        //Set phpzip class for required Excel
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::ZIPARCHIVE);

        //load the data from $file.
        $reader = Excel::load('storage/app/' . $file, function ($reader) {});

        // load rows containing data
        $data = $reader->skipRows(4)->noHeading()->ignoreEmpty()->get()->toArray();

        // set keys using the headers of the file
        $headers = array(
            'store',
            'count',
            'overall_satisfaction_score',
            'overall_satisfaction_n',
            'taste_of_food_score',
            'taste_of_food_n',
            'speed_of_service_score',
            'speed_of_service_n'
        );

        foreach($data as $row){
            //create an array of the $data and set the column headers as the keys and add it to $filedata
            $filedata[] = array_combine($headers, $row); //reset() removes the outer array from keys;
        }

        return $filedata;

    }

    public static function store(){
        //file names for SMG Data
        $files = array(
            'SMGDATA_CW.csv',
            'SMGDATA_PW.csv',
            'SMGDATA_System.csv',
            'SMGDATA_INT_CW.csv',
            'SMGDATA_INT_PW.csv',
            'SMGDATA_INT_System.csv'
        );

        foreach($files as $file){
            $data = self::getFileData($file);
            foreach($data as $row){

                //try to insert data into the DB
                try {

                    switch($file){
                        case 'SMGDATA_CW.csv':
                            $row['type_id'] = 1;
                            break;

                        case 'SMGDATA_PW.csv':
                            $row['type_id'] = 2;
                            break;

                        case 'SMGDATA_System.csv':
                            $row['type_id'] = 3;
                            break;

                        case 'SMGDATA_INT_CW.csv':
                            $row['type_id'] = 1;
                            break;

                        case 'SMGDATA_INT_PW.csv':
                            $row['type_id'] = 2;
                            break;

                        case 'SMGDATA_INT_System.csv':
                            $row['type_id'] = 4;
                            break;
                    }

                    Smg::updateOrCreate(['store' => $row['store'], 'type_id' => $row['type_id']], $row);

                // If there is a Query Error which inserting, run the following
                } catch(\Illuminate\Database\QueryException $ex){
                    // Add the query error to an errorlog table in the DB
                    ErrorLogDB::create(['function'=>$file.': SMG Controller', 'error'=>'MESSAGE: '.$ex->getMessage().'

                     TRACE: '.$ex->getTraceAsString() ]);
                }
            }
        }
        return 'true';
    }
}
