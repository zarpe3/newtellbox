<?php

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
Route::post('/api/broadcasting/auth', function () {
    return true;
});
Route::post('/login', 'App\Http\Controllers\Auth\ApiAuthController@login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/getAccountcode', 'App\Http\Controllers\Asterisk\AGIController@getAccountCode');
    Route::post('/getInbound', 'App\Http\Controllers\Asterisk\AGIController@getInbound');
    Route::post('/getQueue', 'App\Http\Controllers\Asterisk\AGIController@queue');
    Route::post('/getExtens', 'App\Http\Controllers\Asterisk\AGIController@getExtens');
    Route::post('/getTrunk', 'App\Http\Controllers\Asterisk\AGIController@getTrunk');
    Route::post('/rating', 'App\Http\Controllers\Asterisk\AGIController@rating');
    Route::post('/cdr', 'App\Http\Controllers\Asterisk\AGIController@cdr');
    Route::post('/getIVR', 'App\Http\Controllers\Asterisk\AGIController@getIVR');
});

Route::post('/voicemail', 'App\Http\Controllers\Asterisk\VoiceMailController@voicemail');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
