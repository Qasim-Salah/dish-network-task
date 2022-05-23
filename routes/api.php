<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\UserController;
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

Route::middleware(['throttle:60,1'])->prefix('v1')->group(function () {

    ################################## Authenticator routes ######################################

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout')->middleware(['auth:api']);
    });
    ################################## Middleware routes ######################################

    Route::middleware(['auth:api'])->group(function () {

        ################################## User routes ######################################

        Route::prefix('/users')->controller(UserController::class)->name('users.')->group(function () {

            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::post('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');

        });

        ################################## Product routes ######################################

        Route::prefix('/products')->controller(ProductController::class)->name('products.')->group(function () {

            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
            Route::post('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('delete');
        });
    });
});
