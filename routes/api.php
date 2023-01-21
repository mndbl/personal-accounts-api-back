<?php

use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Data\ConsultController;
use App\Http\Controllers\Data\RegisterController;
use App\Http\Controllers\Settings\AccountCategorieController;
use App\Http\Controllers\Settings\AccountController;

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

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);


Route::middleware('auth:sanctum')->prefix('/')->group(function () {
    Route::get('user', [AuthController::class, 'userAuth']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::prefix('settings')->group(function () {
        Route::apiResource('accounts', AccountController::class);
        Route::apiResource('account-categories', AccountCategorieController::class);
    });

    Route::prefix('data')->group(function () {
        Route::apiResource('registers', RegisterController::class);
        Route::get('consult-accounts', [ConsultController::class, 'account_index'])->name('consult.index');
        Route::get('consult-accounts/{id}', [ConsultController::class, 'account_show'])->name('consult.show');
    });
});
