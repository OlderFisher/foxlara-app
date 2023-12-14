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
Route::get('web/students', [StudentsWebController::class, 'index']);
Route::get('web/students/groups', [StudentsWebController::class, 'show']);
Route::get('web/students/create', [StudentsWebController::class, 'create']);
Route::post('web/students/create', [StudentsWebController::class, 'create']);
Route::get('web/students/destroy', [StudentsWebController::class, 'destroy']);
Route::post('web/students/destroy', [StudentsWebController::class, 'destroy']);
Route::get('web/students/groups/transfer', [StudentsWebController::class, 'groupTransfer']);
Route::post('web/students/groups/transfer', [StudentsWebController::class, 'groupTransfer']);
Route::get('web/students/groups/remove', [StudentsWebController::class, 'groupRemove']);
Route::post('web/students/groups/remove', [StudentsWebController::class, 'groupRemove']);
Route::get('web/students/courses/add', [StudentsWebController::class, 'courseAdding']);
Route::post('web/students/courses/add', [StudentsWebController::class, 'courseAdding']);
Route::get('web/students/courses/transfer', [StudentsWebController::class, 'courseTransfer']);
Route::post('web/students/courses/transfer', [StudentsWebController::class, 'courseTransfer']);
Route::get('web/students/courses/remove', [StudentsWebController::class, 'courseRemove']);
Route::post('web/students/courses/remove', [StudentsWebController::class, 'courseRemove']);

