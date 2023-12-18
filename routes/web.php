<?php

use App\Http\Controllers\CrudStructureController;
use App\Http\Controllers\DbStructureController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportDbController;
use App\Http\Controllers\StudentsWebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('laravelcourse');
});
Route::get('/report', [ReportController::class, 'index']);
Route::get('/drivers', [DriverController::class, 'index']);
Route::get('/dbstructure', [DbStructureController::class, 'index']);
Route::get('/dbreport', [ReportDbController::class, 'index']);
//crud app routes
Route::get('/crudstructure', [CrudStructureController::class, 'index']);

Route::prefix('web/students')->group(function () {
    Route::get('/', [StudentsWebController::class, 'index']);
    Route::get('/groups', [StudentsWebController::class, 'show']);
    Route::get('/create', [StudentsWebController::class, 'create']);
    Route::post('/create', [StudentsWebController::class, 'create']);
    Route::get('/destroy', [StudentsWebController::class, 'destroy']);
    Route::post('/destroy', [StudentsWebController::class, 'destroy']);
});
Route::prefix('web/students/groups')->group(function () {
    Route::get('/transfer', [StudentsWebController::class, 'groupTransfer']);
    Route::post('/transfer', [StudentsWebController::class, 'groupTransfer']);
    Route::get('/remove', [StudentsWebController::class, 'groupRemove']);
    Route::post('/remove', [StudentsWebController::class, 'groupRemove']);
});
Route::prefix('web/students/courses')->group(function () {
    Route::get('/add', [StudentsWebController::class, 'courseAdding']);
    Route::post('/add', [StudentsWebController::class, 'courseAdding']);
    Route::get('/transfer', [StudentsWebController::class, 'courseTransfer']);
    Route::post('/transfer', [StudentsWebController::class, 'courseTransfer']);
    Route::get('/remove', [StudentsWebController::class, 'courseRemove']);
    Route::post('/remove', [StudentsWebController::class, 'courseRemove']);
});


