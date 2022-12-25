<?php

use App\Http\Controllers\Oauth\TwitterOauthController;
use App\Http\Controllers\CircleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => '/admin', 'as' => 'admin.'], function (){
        Route::group(['prefix' => '/circle', 'as' => 'circle.'], function (){
            Route::get('/', [CircleController::class, 'index'])->name('index');
            Route::get('/{id}', [CircleController::class, 'show'])->name('show');
        });
    });
});

Route::group(['prefix' => 'oauth/twitter', 'as' => 'oauth.twitter.'], function () {
    Route::get('/login', [TwitterOauthController::class, 'login'])->name('login');
    Route::get('/callback', [TwitterOauthController::class, 'callback'])->name('callback');
});
