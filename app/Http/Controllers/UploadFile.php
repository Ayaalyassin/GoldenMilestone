<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Ods;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class UploadFile extends Controller
{
    public function index( Request $request)
    {
        return view('vendor.voyager.slug-name.fileUpload');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        if ($request->file('file')->isValid()) {
            $fileName = $request->file->getClientOriginalName();

            // Store the file in the storage/files directory
            $path = $request->file->storeAs('public\files', $fileName);

            return redirect()->back()->with('success', 'File uploaded successfully.');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }





    // public function convertAccessToJson()
    // {
    //     // Specify the path to the Access file
    //     $accessFilePath = 'C:\wamp64\www\Golden-Milstone\storage\files\AccesDataBase.accdb';

    //     // Load the Access file using the ODBC driver
    //     $reader = new Ods;
    //     $spreadsheet = $reader->load($accessFilePath);

    //     // Get the first worksheet
    //     $worksheet = $spreadsheet->getActiveSheet();

    //     // Convert the worksheet data to an array
    //     $data = $worksheet->toArray();

    //     // Convert the data to JSON
    //     $json = json_encode($data);

    //     // Specify the path where the JSON file will be saved
    //     $jsonFilePath = 'storage\files\AccesDataBase.accdb';

    //     // Save the JSON data to a file
    //     file_put_contents($jsonFilePath, $json);

    //     return response()->json(['message' => 'Conversion successful']);
    // }


        // print_r(PDO::getAvailableDrivers());
        // print_r(PDO::getAvailableDrivers());
    //     echo PHP_INT_SIZE;
    //     $dsn = "Driver={Microsoft Access Driver (*.mdb, *.accdb)};C:/wamp64/www/Golden-Milstone/storage/files/AccesDataBase.accdb;";
    //    $conn = odbc_connect($dsn, '', '');

// try {
//     $connection = odbc_connect('milstone', 'root', '123');
//     if ($connection) {

//         echo "Connection successful!";
//         dd(DB::connection('odbc'));
//         odbc_close($connection);
//     } else {
//         echo "Connection failed!";
//     }
// } catch (\Exception $e) {
//     echo "Error: " . $e->getMessage();
// }
// $results = DB::connection('odbc')->select('SELECT * FROM Test');
// return response()->json($results);
// $request->validate([
//     'file' => 'required|file|max:2048', // Validate the uploaded file
// ]);

// if ($request->file('file')->isValid()) {
//     $fileName = $request->file->getClientOriginalName(); // Get the original file name
//     $request->file->storeAs('uploads', $fileName); // Store the file in the 'uploads' directory

//    // return redirect()->back()->with('success', 'File uploaded successfully.');
// }

//return redirect()->back()->with('error', 'File upload failed.');
    }

