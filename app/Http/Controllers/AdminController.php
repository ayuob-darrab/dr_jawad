<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\upload_department;
use App\Imports\upload_information;
use App\Models\department;
use App\Models\hashd;
use App\Models\information;
use App\Models\personal_info;
use App\Models\review_info;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Normalizer;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->Upload_new_department == "Upload_new_department") {
            $request->validate([
                'upload_department' => 'required'
            ]);


            Excel::import(new upload_department, $request->file('upload_department'));



            return redirect()->back()->with('success', "تم اضافة التشكيلات بنجاح  ");
        }

        if ($request->Upload_new_information == "Upload_new_information") {
            $request->validate([
                'upload_information' => 'required'
            ]);


            Excel::import(new upload_information, $request->file('upload_information'));



            return redirect()->back()->with('success', "تم اضافة المعلومات بنجاح  ");
        }






        if ($request->add_new_patient == "add_new_patient") {

            // Create a new patient  if it doesn't exist

            //  age to barith
            $age = $request->patient_age;
            $today = \Carbon\Carbon::now();
            $birthday = $today->subYears($age);
            $year = $birthday->year; // Get the year
            $month = $birthday->month; // Get the month
            $day = $birthday->day; // Get the day

            // dd();

            $birthday = $year . '-' . $month . '-' . $day;
            // dd($birthday);




            $add_new_patient =  new personal_info();

            $add_new_patient->name = $request->patient_name;
            $add_new_patient->birthday = $birthday;
            $add_new_patient->check_date = date("Y-m-d");//\Carbon\Carbon::now()->format('d-m-y');
            $add_new_patient->patient_phone = $request->patient_phone;
            $add_new_patient->type_patient = $request->type_patient;
            $add_new_patient->note_patient = $request->note_patient;

            $add_new_patient->save();
            return redirect()->back()->with('success', "  تم اضافة المريض بنجاح  ");
        }


        if ($request->add_new_visit_patient == "add_new_visit_patient") {



            $patient_name = personal_info::where('id', $request->patient__id__)->first();
            // dd($patient_name);

            $patient_name = $patient_name->name;

            // Create a new patient  if it doesn't exist

            $add_new_visit_patient =  new review_info();


            $add_new_visit_patient->patient_id = $request->patient__id__;
            $add_new_visit_patient->path = 0;
            $add_new_visit_patient->code = 0;
            $add_new_visit_patient->check_date = date("Y-m-d");// \Carbon\Carbon::now()->format('y-m-d');;


            $add_new_visit_patient->save();



            return redirect('/operations/management_patient_info')->with('success', "  تم اضافة   مراجعة جديدة للمريض   : $patient_name ");
            // return redirect('/dr_jawad/operations/management_patient_info')->back()->with('success', "  تم اضافة  المراجعة بنجاح  ");
        }






    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {




        if ($id == "accounts") {
            $users = User::get();
            return view('admin.accounts', compact('users'));
        }


        if ($id == "report_count") {

            // $today = now()->format('Y-m-d');
            $check_date = date("Y-m-d");
            $daily = review_info::where('check_date', $check_date)->count();

            $weeklyStart = now()->startOfWeek()->format('Y-m-d');
            $weeklyEnd = now()->endOfWeek()->format('Y-m-d');
            $weekly = review_info::whereBetween('check_date', [$weeklyStart, $weeklyEnd])->count();

            $monthlyStart = now()->startOfMonth()->format('Y-m-d');
            $monthlyEnd = now()->endOfMonth()->format('Y-m-d');
            $monthly = review_info::whereBetween('check_date', [$monthlyStart, $monthlyEnd])->count();



            // $monthlyStart = now()->startOfMonth()->format('Y-m-d');
            // $monthlyEnd = now()->endOfMonth()->format('Y-m-d');
            // $monthlyData = review_info::whereBetween('check_date', [$monthlyStart, $monthlyEnd])->get();
            // dd($monthlyStart, $monthlyEnd);


            return view('manage.report_count' , compact('daily', 'weekly', 'monthly'));
        }




        if ($id == "upload_page") {
            return view('home.home_upload');
        }
        if ($id == "upload_department") {
            return view('admin.upload_department');
        }

        if ($id == "upload_information") {
            return view('admin.upload_information');
        }

        if ($id == "new_patient") {



            return view('add_new.add_new_patient');
        }


        if ($id == "reports") {

            $all_patients = personal_info::paginate(10);
            $searchText = '';

            // $prs = personal_info::paginate(50);
            return view('home.home_reports', compact('all_patients', 'searchText'));

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pieces = explode("&", $id);



        if ($pieces[1] == 'edit_user') {
            $EditUser = User::where('id', $pieces[0])->first();
            return view('admin.update_user', compact('EditUser'));
        }


        if ($pieces[1] == 'delete_patient') {
            // dd('dfdfdf');

            $personal_visit = personal_info::where('id', $id)->first();
            $review_visits = review_info::where('patient_id', $personal_visit->id)->orderBy('created_at', 'desc')->get();


            // return view('test', compact('personal_visit', 'review_visits'));
            return view('manage.delete_action', compact('personal_visit', 'review_visits'));
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if ($request->Update_user_info == 'Update_user_info') {
            $update_user = User::where('id', $id)->first();
            $update_user->name = $request->name;
            $update_user->username = $request->username;
            $update_user->type = $request->type_user;

            if ($request->check_password == "on") {
                $update_user->password = Hash::make($request->new_password);
            } else {
                $update_user->password =  $update_user->password;
            }
            $update_user->save();
            return redirect('/admin/accounts')->with('success', "تم تحديث المعلومات");
        }



        if ($request->add_patient_file == "add_patient_file") {



            // if ($request->hasFile('patient_file')) {
            //     // Your file processing logic goes here
            // } else {
            //     // Handle the case where no file is present
            // }


            $request->validate(
                [
                    'patient_file' => 'required|mimes:jpeg,png,jpg,gif',
                    // 'info_title' => 'required',

                ],
                [
                    'patient_file.mimes' => 'يجب ارفاق ملف نوع jpeg,png,jpg,gif',
                ]
            );

            $add_patient_file = personal_info::where('id', $id)->first();

            $add_patient_file->patient_phone = $request->patient_phone;
            $add_patient_file->note_patient = $request->note_patient;

            $add_patient_file->save();





            // $timeNews = \Carbon\Carbon::now()->format('Y-m-d-h-m-s');
            // $image = $request->patient_file;
            // $Extension = $image->getClientOriginalExtension();
            // $image_name = $add_patient_file->id . '-' . $timeNews . '.' . "PNG";

            // $directoryPath = 'PatientFiles';

            // if (!is_dir($directoryPath . '/')) {
            //     mkdir($directoryPath . '/');
            // }
            // $destinationPath = $directoryPath . '/';
            // $image->move($destinationPath, $image_name);
            // $finalPath = $destinationPath . $image_name;



            $timeNews = \Carbon\Carbon::now()->format('Y-m-d-h-m-s');
            $image = $request->patient_file;
            $extension = $image->getClientOriginalExtension();
            $image_name = $add_patient_file->id . '-' . $timeNews . '.' . "PNG";

            $directoryPath = public_path('PatientFiles');

            // Check if the directory doesn't exist, then create it
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath);
            }

            $destinationPath = $directoryPath . '/';
            $image->move($destinationPath, $image_name);
            $finalPath = $destinationPath . $image_name;





            $add_new_visit_patient =  new review_info();
            $add_new_visit_patient->patient_id = $request->patient__id__;
            $add_new_visit_patient->path = $image_name;
            $add_new_visit_patient->code = 0;
            $add_new_visit_patient->check_date = date("Y-m-d");
            $add_new_visit_patient->save();
            return back()->with('success', 'تم تحميل التشخيص  بنجاح :  '   .  $add_patient_file->name);

        }



        if ($request->update_informatioons == "update_informatioons") {



             if ($request->has('patient_name')) {


                $update_informatioons = personal_info::where('id', $id)->first();

                $name = $update_informatioons->name;

                $update_informatioons->name = $request->patient_name;
                $update_informatioons->patient_phone = $request->patient_phone;
                $update_informatioons->note_patient = $request->note_patient;

                $update_informatioons->save();




                return back()->with('success', 'تم  تعديل المعلومات  بنجاح للمريض :  ' . $name);
            } else {
                return back()->with('danger', 'الرجاء كتابة المعلومات الشخصية للمريض:    ' );
            }






        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,  $id)
    {

        if ($request->destroy_all_informations == 'destroy_all_informations') {


            $destroy_all_informations = personal_info::where('id', $id)->first();


            $destroy_all_reviews = review_info::where('patient_id', $destroy_all_informations->id)->get();
            $patient_name =  $destroy_all_informations->name;

            foreach ($destroy_all_reviews as $destroy_all_review) {
                $filePath = public_path('PatientFiles/' . $destroy_all_review->path);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }



            }
            review_info::where('patient_id', $destroy_all_informations->id)->delete();


            if ($destroy_all_informations) {
                $destroy_all_informations->delete();
                return redirect('/report')->with('success', 'تم مسح جميع المعلومات بنجاح   :  '. $patient_name);
            } else {
                // Handle the case where the record with the given $id is not found
                return redirect('/report')->with('danger', 'لم يتم العثور على المعلومات المراد مسحها');
            }
        }


        if ($request->destroy_review == 'destroy_review') {




            $destroy_review = review_info::where('id', $id)->first();



                $filePath = public_path('PatientFiles/' . $destroy_review->path);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

            $check_date =  $destroy_review->check_date;



            if ($destroy_review) {
                $destroy_review->delete();
                return back()->with('success', 'تم مسح المراجعة  بنجاح بتاريخ    :  '. $check_date);
            } else {
                // Handle the case where the record with the given $id is not found
                return redirect('/report')->with('danger', 'لم يتم العثور على المعلومات المراد مسحها');
            }
        }
    }
}
