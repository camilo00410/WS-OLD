<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::middleware('auth.token', function(){

    });

    Route::post('organizers/{oslug}/events/{eslug}/registration', 'Api\EventController@registration');

    Route::get('registrations', 'Api\EventController@list');

    Route::post('logout', 'Api\UserController@logout');

    Route::post('login', 'Api\UserController@login');

    Route::get('events', 'Api\EventController@index');

    Route::get('organizers/{oslug}/events/{eslug}', 'Api\EventController@show');
});