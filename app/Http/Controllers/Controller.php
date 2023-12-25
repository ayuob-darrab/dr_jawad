<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\hashd;
use App\Models\personal_info;
use App\Models\review_info;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;




    public function homepage(Request $request)
    {
        $all_patients = personal_info::paginate(10);
         $searchText = '';

        // $prs = personal_info::paginate(50);
        return view('homePage', compact('all_patients', 'searchText'));

    }






    public function search(Request $request)
    {
        // dd($request->search_name);

        if ($request->has('search_name')) {
            $searchText = $request->input('search_name');
            $all_patients = personal_info::where('name', 'like', '%' . $searchText . '%')->paginate(10);

            if ($all_patients->isEmpty()) {
                return back()->with('danger', "الاسم الذي تم البحث عنة غير موجود : ". $searchText);
            }


            return view('homePage', compact('all_patients', 'searchText'));
        }


    }



    public function reports_search(Request $request)
    {


        if ($request->has('search_name')) {
            $searchText = $request->input('search_name');
            $all_patients = personal_info::where('name', 'like', '%' . $searchText . '%')->paginate(10);

            if ($all_patients->isEmpty()) {
                return back()->with('danger', "الاسم الذي تم البحث عنة غير موجود : ". $searchText);
            }


            return view('home.home_reports', compact('all_patients', 'searchText'));
        }


    }


    public function report(Request $request)
    {
        $all_patients = personal_info::paginate(10);
        $searchText = '';

        // $prs = personal_info::paginate(50);
        return view('home.home_reports', compact('all_patients', 'searchText'));
    }

    public function backup_database()
    {
        $host = "localhost";
        $username = "root";
        $password = "adsl1234@";
        $database_name = "dr_jawad";

        // Get connection object and set the charset
        $conn = mysqli_connect($host, $username, $password, $database_name);
        $conn->set_charset("utf8");


        // Get All Table Names From the Database
        $tables = array();
        $sql = "SHOW TABLES";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }

        $sqlScript = "";
        foreach ($tables as $table) {

            // Prepare SQLscript for creating table structure
            $query = "SHOW CREATE TABLE $table";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);

            $sqlScript .= "\n\n" . $row[1] . ";\n\n";


            $query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $query);

            $columnCount = mysqli_num_fields($result);

            // Prepare SQLscript for dumping data for each table
            for ($i = 0; $i < $columnCount; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $sqlScript .= "INSERT INTO $table VALUES(";
                    for ($j = 0; $j < $columnCount; $j++) {
                        $row[$j] = $row[$j];

                        if (isset($row[$j])) {
                            $sqlScript .= '"' . $row[$j] . '"';
                        } else {
                            $sqlScript .= '""';
                        }
                        if ($j < ($columnCount - 1)) {
                            $sqlScript .= ',';
                        }
                    }
                    $sqlScript .= ");\n";
                }
            }

            $sqlScript .= "\n";
        }

        if (!empty($sqlScript)) {
            // Save the SQL script to a backup file
            $backup_file_name = $database_name . '_backup_' . time() . '.sql';
            $fileHandler = fopen($backup_file_name, 'w+');
            $number_of_lines = fwrite($fileHandler, $sqlScript);
            fclose($fileHandler);

            // Download the SQL backup file to the browser
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backup_file_name));
            ob_clean();
            flush();
            readfile($backup_file_name);
            exec('rm ' . $backup_file_name);
        }
    }


}
