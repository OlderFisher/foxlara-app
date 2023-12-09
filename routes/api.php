<?php

use App\Http\Controllers\Api\V1\GroupsController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/v1/report', [ReportController::class, 'index']);
Route::get('/v1/groups', [GroupsController::class, 'index']);
Route::get('/v1/students', [StudentsController::class, 'index']);
Route::post('/v1/students/', [StudentsController::class, 'store']);
Route::post('/v1/students/{studentId}', [StudentsController::class, 'destroy']);
Route::post('/v1/students/{studentId}/groups/{groupId}', [StudentsController::class, 'update']);
Route::post('/v1/groups/{groupId}/students/{studentId}', [GroupsController::class, 'remove']);
