<?php

use App\Http\Controllers\Api\V1\GroupsController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\StudentsApiController;
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

Route::prefix('/v1/students',)->group(function () {
    Route::get('/', [StudentsApiController::class, 'index']);
    Route::post('/', [StudentsApiController::class, 'store']);
    Route::delete('/{studentId}', [StudentsApiController::class, 'destroy']);
    Route::put('/{studentId}/groups/{groupId}', [StudentsApiController::class, 'update']);
    Route::put('/{studentId}/add/courses/{courseId}', [StudentsApiController::class, 'courseAdding']);
    Route::put('/{studentId}/remove/courses/{courseId}', [StudentsApiController::class, 'courseRemove']);
});
Route::put('/v1/groups/students/{studentId}', [StudentsApiController::class, 'remove']);
