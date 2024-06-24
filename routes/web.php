<?php

use App\Http\Controllers\ChatsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MarkA1Controller;
use App\Http\Controllers\PusherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadFile;
use App\Http\Controllers\NewTableController;
use App\Http\Controllers\QuestionGrammerController;
use App\Http\Controllers\AppointmentController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
   // Route::get('files',[UploadFile::class,'index']);
    // Route::GET('files', ['uses' => 'UploadFile@index']);
    //Route::post('files', [UploadFile::class,'index']);
    Route::get('/files', [UploadFile::class, 'index']);
    Route::get('/chats', [PusherController::class, 'index']);
    Route::get('/course', [CourseController::class, 'index']);
   // Route::get('/course', [NewTableController::class, 'index']);

});

Route::get('/new-table', [NewTableController::class, 'create']);
Route::post('/new-table', [NewTableController::class, 'store']);

Route::post('/upload', [UploadFile::class, 'upload'])->name('upload');

Route::post('/uploadCourse', [CourseController::class, 'uploadFiles'])->name('uploadCourse');
Route::get('/mark_a1/create', [MarkA1Controller::class, 'create'])->name('mark_a1.create');
Route::post('/mark_a1', [MarkA1Controller::class, 'store'])->name('mark_a1.store');
Route::get('/form', [QuestionGrammerController::class, 'showForm'])->name('show_form');
Route::post('/form', [QuestionGrammerController::class, 'submitForm'])->name('submit_form');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
