<?php

use App\Http\Controllers\Api\v1\AuthenticationController;
use App\Http\Controllers\Api\v1\ForgotPasswordController;
use App\Http\Controllers\Api\v1\TaskController;
use Illuminate\Http\Request;
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


Route::name('api.')
    ->prefix('v1')
    ->group(function () {
        Route::group(['middleware' => 'guest'], function () {
            Route::post('login', [AuthenticationController::class, 'login'])->name('login');
            Route::post('register', [AuthenticationController::class, 'register'])->name('register');
            Route::post('forgot-password', [ForgotPasswordController::class, 'forgot'])->name('password.forgot');
            Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.reset');
            Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
        });

        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::resource('tasks', TaskController::class);
            Route::post('/tasks/sort', [TaskController::class, 'sort'])->name('tasks.sort');
        });
    });
