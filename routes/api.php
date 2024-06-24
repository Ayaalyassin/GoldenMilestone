<?php

use App\Http\Controllers\CourseController;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\RolenMiddleware;
use App\Http\Controllers\AdminActionController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\GrammerController;
use App\Http\Controllers\QuestionGrammerController;
use App\Http\Controllers\AnswerGrammerController;
use App\Http\Controllers\QuestionLevelController;
use App\Http\Controllers\AnswerLevelController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/pdf', [CourseController::class, 'viewFilesPdf']);
Route::get('/voice', [CourseController::class, 'viewFilesVoice']);


Route::post('/download-pdf', function (Request $request) {
    $pdfPath = $request->input('pdf_path');
    $filePath = storage_path($pdfPath);

    if (File::exists($filePath)) {
        return response()->download($filePath);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});

Route::post('/download-voice', function (Request $request) {
    $voicePath = $request->input('voice_path');
    $filePath =storage_path($voicePath);

    if (File::exists($filePath)) {
        return response()->download($filePath);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});



## For Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post("login", [AuthUserController::class, 'login']);
    Route::post("register", [AuthUserController::class, 'register']);
    Route::post('logout', [AuthUserController::class, 'logout'])->middleware('jwt.verify');
    Route::get('me', [AuthUserController::class, 'me'])->middleware('jwt.verify');
});


/* After Login */
Route::group(['middleware' => ['jwt.verify']], function () {


    Route::post('post_profile',[AuthUserController::class, 'post_profile']);


    Route::group(['prefix' => 'postes'], function () {
    Route::get('',[AdminActionController::class,'index']);
    Route::post('/newpost',[AdminActionController::class,'store']);//->middleware(['role:admin']);
    Route::get('{id}', [AdminActionController::class, 'show']);//->middleware(['role:user|admin']);
    Route::delete('{id}', [AdminActionController::class, 'delete']);//->middleware(['role:admin']);
    });




    Route::get('/orders', [OrderController::class,'index']);//->middleware(['role:admin']);
    Route::post('/{appointment_id}/orders',[OrderController::class,'store']);//->middleware(['role:admin|user']);
    Route::get('/orders/{order}', [OrderController::class,'show']);//->middleware(['role:admin']);
    //Route::post('/orders/{id}',[OrderController::class,'update'])->middleware(['role:admin']);
    Route::delete('/orders/{id}',[OrderController::class,'destroy']);//->middleware(['role:admin']);

//Route::post('addstudent',[AdminActionController::class,'addstudent'])->middleware(['role:admin']);

Route::prefix('appointments')->group(function(){
    Route::get('/', [AppointmentController::class,'index']);//->middleware(['role:user|admin']);
    Route::post('/',[AppointmentController::class,'store']);//->middleware(['role:admin']);
    Route::get('/{appointment}',[AppointmentController::class,'show']);//->middleware(['role:user|admin']);
    Route::post('/{appointment}',[AppointmentController::class,'update']);//->middleware(['role:admin']);
    Route::delete('/{appointment}',[AppointmentController::class,'destroy']);//->middleware('role:admin');
});

Route::prefix('levels')->group(function(){

    Route::get('/', [LevelController::class,'index']);//->middleware(['role:user|admin']);
    Route::post('/',[LevelController::class,'store']);//->middleware(['role:admin']);
    Route::get('/{level_id}',[LevelController::class,'show']);//->middleware(['role:user|admin']);
    Route::post('/{level_id}',[LevelController::class,'updat']);//->middleware(['role:admin']);
    Route::delete('/{level_id}',[LevelController::class,'destroy']);//->middleware(['role:admin']);

});

Route::group(['prefix' => 'grammers'], function () {
    Route::get('/index/{level_id}', [GrammerController::class, 'index']);//->middleware(['role:user|admin']);
    Route::post('/', [GrammerController::class, 'store']);//->middleware(['role:admin']);
    Route::post('/{grammer_id}', [GrammerController::class, 'update']);//->middleware(['role:admin']);
    Route::get('/show/{grammer_id}', [GrammerController::class, 'show']);//->middleware(['role:user|admin']);
    Route::delete('/{grammer_id}', [GrammerController::class, 'destroy']);//->middleware(['role:admin']);
});



Route::group(['prefix' => 'QueGrammer'], function () {
    Route::get('/getAll/{grammer_id}', [QuestionGrammerController::class, 'getAll']);//->middleware(['role:user|admin']);
    Route::post('/', [QuestionGrammerController::class, 'save']);//->middleware(['role:admin']);
    Route::post('/{question_id}', [QuestionGrammerController::class, 'update']);//->middleware(['role:admin']);
    Route::get('/show/{question_id}', [QuestionGrammerController::class, 'getById']);//->middleware(['role:user|admin']);
    Route::delete('/{question_id}', [QuestionGrammerController::class, 'delete']);//->middleware(['role:admin']);
});


Route::group(['prefix' => 'AnsGrammer'], function () {
    Route::get('/{grammer_id}', [AnswerGrammerController::class, 'getAll']);//->middleware(['role:user|admin']);
    Route::post('/', [AnswerGrammerController::class, 'save']);//->middleware(['role:admin']);
    Route::post('/{answer_id}', [AnswerGrammerController::class, 'update']);//->middleware(['role:admin']);
    Route::get('/show/{answer_id}', [AnswerGrammerController::class, 'getById']);//->middleware(['role:user|admin']);
    Route::delete('/{answer_id}', [AnswerGrammerController::class, 'delete']);//->middleware(['role:user|admin']);
    Route::post('/answer/{question_id}', [AnswerGrammerController::class, 'answer']);//->middleware(['role:user|admin']);
    Route::get('/ret_true/{grammer_id}', [AnswerGrammerController::class, 'ret_true']);//->middleware(['role:user|admin']);
});


Route::group(['prefix' => 'QueLevel'], function () {
    Route::get('/', [QuestionLevelController::class, 'getAll']);//->middleware(['role:user|admin']);
    Route::post('/', [QuestionLevelController::class, 'save']);//->middleware(['role:admin']);
    Route::post('/{question_id}', [QuestionLevelController::class, 'update']);//->middleware(['role:admin']);
    Route::get('/{question_id}', [QuestionLevelController::class, 'getById']);//->middleware(['role:user|admin']);
    Route::delete('/{question_id}', [QuestionLevelController::class, 'delete']);//->middleware(['role:admin']);
});


Route::group(['prefix' => 'AnsLevel'], function () {
    Route::get('/', [AnswerLevelController::class, 'getAll']);//->middleware(['role:user|admin']);
    Route::post('/', [AnswerLevelController::class, 'save']);//->middleware(['role:admin']);
    Route::post('/{answer_id}', [AnswerLevelController::class, 'update']);//->middleware(['role:admin']);
    Route::get('/{answer_id}', [AnswerLevelController::class, 'getById']);//->middleware(['role:user|admin']);
    Route::delete('/{answer_id}', [AnswerLevelController::class, 'delete']);//->middleware(['role:user|admin']);
    Route::post('/answer/{question_id}', [AnswerLevelController::class, 'answer']);//->middleware(['role:user|admin']);
    Route::get('/calc/lev', [AnswerLevelController::class, 'clac_lev']);//->middleware(['role:user|admin']);
});

Route::post('/addRoleU', [ AdminActionController::class, 'addRoleU']);//->middleware(['role:admin']);
//Route::post('/addPermission', [ AdminActionController::class, 'setPermissionR'])->middleware(['role:admin']);
Route::post('/addRolee', [ AdminActionController::class, 'addRolee']);//->middleware(['role:admin']);
Route::post('/addpermissionc', [ AdminActionController::class, 'addpermissionc']);//->middleware(['role:admin']);
Route::post('/addstudent',[ AdminActionController::class, 'addstudent']);//->middleware(['role:admin']);

});
