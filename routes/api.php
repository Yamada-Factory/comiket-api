<?php

use App\Http\Controllers\Api\V1\Circle\CircleCreateController;
use App\Http\Controllers\Api\V1\Circle\CircleDeleteController;
use App\Http\Controllers\Api\V1\Circle\CircleGetController;
use App\Http\Controllers\Api\V1\Event\EventCreateController;
use App\Http\Controllers\Api\V1\Event\EventDeleteController;
use App\Http\Controllers\Api\V1\Event\EventGetController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'as' => 'auth.', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => '/circle', 'as' => 'circle.'], function (){
        Route::post('', CircleCreateController::class)->name('create');
        Route::get('/{id}', CircleGetController::class)->name('getId');
        Route::delete('/{id}', CircleDeleteController::class)->name('delete');
    });

    Route::group(['prefix' => '/event', 'as' => 'event.'], function (){
        Route::post('', EventCreateController::class)->name('create');
        Route::get('/{id}', EventGetController::class)->name('getId');
        Route::delete('/{id}', EventDeleteController::class)->name('delete');
    });
});
