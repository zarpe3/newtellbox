<?php

use App\Models\Customer;
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
Route::get('/{customer}/app', function (Customer $customer) {
    var_dump($customer);
});
Route::get('/test', 'App\Http\Controllers\HomeController@test');
//// Logout

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'customer'], function () {
        Route::post('/plan', [
            'as' => 'customer.add.plan', 'uses' => 'App\Http\Controllers\CustomersController@addPlan',
        ]);
    });
    Route::post('/me', 'App\Http\Controllers\UserController@me');
});

Route::group(['prefix' => '{customer}'], function () {
    Route::group(['middleware' => ['auth', 'view']], function () {
        Route::get('/home', 'App\Http\Controllers\HomeController@showDashboard');
        Route::get('/home/json', 'App\Http\Controllers\HomeController@getCustomers');
        Route::resource('/users', 'App\Http\Controllers\UserController', ['except' => ['show']]);
        Route::resource('/extens', 'App\Http\Controllers\ExtensController');

        Route::resource('/routes', 'App\Http\Controllers\RoutesController');
        Route::resource('/inbound', 'App\Http\Controllers\InboundController');
        Route::resource('/queue', 'App\Http\Controllers\QueueController');
        Route::resource('/trunks', 'App\Http\Controllers\TrunksController');
        Route::resource('/audios', 'App\Http\Controllers\AudiosController');
        Route::resource('/trunks-advanced', 'App\Http\Controllers\TrunksAdvancedController');
        Route::resource('/reception', 'App\Http\Controllers\ReceptionConsoleController');
        Route::resource('/ivr', 'App\Http\Controllers\IVRController');
        Route::post('/reception/hangup', 'App\Http\Controllers\ReceptionConsoleController@hangup');
        Route::post('/reception/transfer/{number}', 'App\Http\Controllers\ReceptionConsoleController@transfer');
        Route::post('/reception/spy/{number}', 'App\Http\Controllers\ReceptionConsoleController@spy');

        Route::get('/voicemail', [
            'as' => 'voicemail.index', 'uses' => 'App\Http\Controllers\Asterisk\VoiceMailController@show', ]);
        Route::post('/voicemail', [
            'as' => 'voicemail.update', 'uses' => 'App\Http\Controllers\Asterisk\VoiceMailController@update', ]);

        Route::group(['prefix' => 'report'], function () {
            Route::get('/cdr', ['as' => 'cdr.index', 'uses' => 'App\Http\Controllers\CdrController@index']);
            Route::post('/cdr/search', ['as' => 'cdr.search', 'uses' => 'App\Http\Controllers\CdrController@search']);
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
            Route::patch('/', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
            Route::patch('/password', [
                    'as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password',
            ]);
        });

        Route::group(['prefix' => 'mailing'], function () {
            Route::get('/', ['as' => 'mailing.index', 'uses' => 'App\Http\Controllers\MailingController@index']);
            Route::get('/create', ['as' => 'mailing.create', 'uses' => 'App\Http\Controllers\MailingController@create']);
            Route::post('/', ['as' => 'mailing.store', 'uses' => 'App\Http\Controllers\MailingController@store']);
            Route::get('/{id}', ['as' => 'mailing.show', 'uses' => 'App\Http\Controllers\MailingController@show']);
            Route::patch('/{id}', ['as' => 'mailing.update', 'uses' => 'App\Http\Controllers\MailingController@update']);
            Route::delete('/{id}', ['as' => 'mailing.destroy', 'uses' => 'App\Http\Controllers\MailingController@destroy']);
            Route::get('/{id}/edit', ['as' => 'mailing.edit', 'uses' => 'App\Http\Controllers\MailingController@edit']);
            Route::post('/import', 'App\Http\Controllers\MailingController@import');
            Route::post('/start/{id}', 'App\Http\Controllers\MailingController@start');
            Route::post('/pause/{id}', 'App\Http\Controllers\MailingController@pause');
            ///Route::resource('/', 'App\Http\Controllers\MailingController');
        });

        Route::get('/mailing-export-error', 'App\Http\Controllers\MailingController@exportError');
        Route::get('/mailing-follow-up', 'App\Http\Controllers\MailingController@followUp');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
