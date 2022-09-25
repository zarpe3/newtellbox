<?php

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

Auth::routes();

Route::get('/', 'App\Http\Controllers\HomeController@index');

Route::get('/test', 'App\Http\Controllers\HomeController@test');

//// Logout

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/users', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::resource('/extens', 'App\Http\Controllers\ExtensController');

    Route::resource('/routes', 'App\Http\Controllers\RoutesController');
    Route::resource('/trunks', 'App\Http\Controllers\TrunksController');
    Route::resource('/trunks-advanced', 'App\Http\Controllers\TrunksAdvancedController');
    Route::resource('/reception', 'App\Http\Controllers\ReceptionConsoleController');

    Route::group(['prefix' => 'report'], function () {
        Route::get('/cdr', ['as' => 'cdr.index', 'uses' => 'App\Http\Controllers\CdrController@index']);
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
        Route::patch('/', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
        Route::patch('/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::post('/plan', ['as' => 'customer.add.plan', 'uses' => 'App\Http\Controllers\CustomersController@addPlan']);
    });

    Route::post('/me', 'App\Http\Controllers\UserController@me');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
