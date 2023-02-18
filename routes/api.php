<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Board\BoardController;
use App\Http\Controllers\Api\Task\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
//create task point
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('getTask', [TaskController::class, 'getTask']);
    Route::post('createTask', [TaskController::class, 'create'])->name('createTask');
    Route::delete('deleteTask', [TaskController::class, 'delete'])->name('deleteTask');
    Route::put('editTask', [TaskController::class, 'edit'])->name('editTask');

    Route::get('getBoard', [BoardController::class, 'getData']);
    Route::post('createBoard', [BoardController::class, 'create']);
    Route::delete('deleteBoard', [BoardController::class, 'delete'])->name('deleteBoard');
    Route::put('editBoard', [BoardController::class, 'edit'])->name('editBoard');
});

// //task create
// Route::post('createTask', [TaskController::class, 'create'])->name('createTask');
// Route::delete('deleteTask', [TaskController::class, 'delete'])->name('deleteTask');
// Route::put('editTask', [TaskController::class, 'edit'])->name('editTask');
