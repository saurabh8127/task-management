<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\TaskPoint\TaskPointController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//task create 
Route::post('createTask', [TaskController::class, 'create'])->name('createTask');
Route::delete('deleteTask', [TaskController::class, 'delete'])->name('deleteTask');
Route::post('editTask', [TaskController::class, 'edit'])->name('editTask');

//create task point 
Route::post('createTaskPoint', [TaskPointController::class, 'create'])->name('createTaskPoint');
Route::delete('deleteTaskPoint', [TaskPointController::class, 'delete'])->name('deleteTaskPoint');
Route::post('editTaskPoint', [TaskPointController::class, 'edit'])->name('editTaskPoint');
