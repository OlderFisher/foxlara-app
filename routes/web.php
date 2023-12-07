<?php

use App\Http\Controllers\CrudAppController;
use App\Http\Controllers\CrudStructureController;
use App\Http\Controllers\DbStructureController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportDbController;
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
Route::get('/crudstructure', [CrudStructureController::class, 'index']);
Route::get('/crudapp', [CrudAppController::class, 'index']);
Route::get('/crudapp/students', [CrudAppController::class, 'show']);
Route::post('/crudapp/students/store', [CrudAppController::class, 'store']);
Route::post('/crudapp/students/destroy', [CrudAppController::class, 'destroy']);

