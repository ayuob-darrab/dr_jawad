<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\hashd;
use App\Models\personal_info;
use App\Models\review_info;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    


    // view info for all isit patient
    public function add_patient_visit($id)
    {
        // Get the department based on the provided ID

        $patient_visit_info = personal_info::where('id', $id)->first();



        return view('add_new.manage_patient_visit', compact('patient_visit_info'));
    }







    // view info for all isit patient
    public function manage_patient_visit($id)
    {
        // Get the department based on the provided ID


        $personal_visit = personal_info::where('id', $id)->first();
        $review_visits = review_info::where('patient_id', $personal_visit->id)->orderBy('created_at', 'desc')->get();


        // return view('test', compact('personal_visit', 'review_visits'));
        return view('manage.personal_visit', compact('personal_visit', 'review_visits'));
    }
































}
