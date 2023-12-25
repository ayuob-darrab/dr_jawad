<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\operationsController;
use App\Http\Controllers\ReportController;
use App\Models\document;
use App\Models\hashd;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// DocumentController

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Routes that require authentication

    Route::get('/', function () {
        return view('manage.all_patient_show');
        // return view('home.home');
    });

    // Route::get('/dr_jawad', function () {
    //     // return view('home.home');
    //     return view('manage.all_patient_show');
    // })->name('dr_jawad');


    // Route::get('/home', function () {
    //     return view('home.home');
    // })->name('home');




    Route::get('/home', [Controller::class, 'homepage'])->name('home');
    Route::get('/dr_jawad', [Controller::class, 'homepage'])->name('dr_jawad');
    Route::get('/', [Controller::class, 'homepage']);


    Route::get('/report', [Controller::class, 'report'])->name('report');


    Route::get('/search', [Controller::class, 'search'])->name('search');
    Route::get('/reports_search', [Controller::class, 'reports_search'])->name('reports_search');

    //    عرض مرت المراجعات
    Route::get('/manage_patient_visit/{id}', [HomeController::class, 'manage_patient_visit'])->name('manage_patient_visit');




    Route::get('/backup_database', [Controller::class, 'backup_database'])->name('backup_database');





    Route::post('/dr_jawad/register', [RegisterController::class, 'add_newuser']);


    Route::resource("/admin", "AdminController");
    Route::resource("/operations", "operationsController");

    // Route::get('/fast_receice/{id}', [Controller::class, 'index'])->name('fast_receice');
    // Route::post('/search', [Controller::class, 'searchAndUpdate'])->name('search.update');









});
