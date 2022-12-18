<?php

use App\Http\Controllers\Api\V1\Auth\User\UserFavoriteCreateController;
use App\Http\Controllers\Api\V1\Auth\User\UserFavoriteGetController;
use App\Http\Controllers\Api\V1\Auth\User\UserGetController;
use App\Http\Controllers\Api\V1\Circle\CircleCreateController;
use App\Http\Controllers\Api\V1\Circle\CircleDeleteController;
use App\Http\Controllers\Api\V1\Circle\CircleGetController;
use App\Http\Controllers\Api\V1\Event\EventCircleCreateController;
use App\Http\Controllers\Api\V1\Event\EventCircleGetController;
use App\Http\Controllers\Api\V1\Event\EventCreateController;
use App\Http\Controllers\Api\V1\Event\EventDeleteController;
use App\Http\Controllers\Api\V1\Event\EventGetController;
use App\Http\Controllers\Api\V1\Event\EventGetListController;
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
        Route::delete('/{id}', CircleDeleteController::class)->name('delete');
    });

    Route::group(['prefix' => '/event', 'as' => 'event.'], function (){
        Route::post('', EventCreateController::class)->name('create');
        Route::delete('/{id}', EventDeleteController::class)->name('delete');

        Route::group(['as' => 'event.circle.'], function () {
            Route::post('/{id}/circle', EventCircleCreateController::class)->name('create');
        });
    });
});

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    // 認証必須
    Route::group(['prefix' => '/auth', 'as' => 'auth.', 'middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => '/user', 'as' => 'user.'], function () {
            Route::get('', UserGetController::class)->name('info');

            Route::group(['prefix' => '/favorite', 'as' => 'favorite.'], function () {
                Route::get('', UserFavoriteGetController::class)->name('index');
                Route::post('', UserFavoriteCreateController::class)->name('create');
            });
        });
    });

    Route::group(['prefix' => '/circle', 'as' => 'circle.'], function (){
        Route::get('/{id}', CircleGetController::class)->name('get');
    });

    Route::group(['prefix' => '/event', 'as' => 'event.'], function (){
        Route::get('', EventGetListController::class)->name('list');
        Route::get('/{id}', EventGetController::class)->name('get');
        Route::get('/{id}/circle', EventCircleGetController::class)->name('circle.get');
    });
});
