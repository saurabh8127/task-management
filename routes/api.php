<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
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

//register route
Route::post('register', [RegisterController::class, 'register']);

//login route
Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {

    //logout route api
    Route::post('logout', [LogoutController::class, 'logout']);

    //board api route
    Route::get('getBoard', [BoardController::class, 'getData']);
    Route::post('createBoard', [BoardController::class, 'create']);
    Route::delete('deleteBoard', [BoardController::class, 'delete']);
    Route::put('editBoard', [BoardController::class, 'edit']);

    //task api route
    Route::get('getTask', [TaskController::class, 'getTask']);
    Route::post('createTask', [TaskController::class, 'create']);
    Route::delete('deleteTask', [TaskController::class, 'delete']);
    Route::put('editTask', [TaskController::class, 'edit']);

});
