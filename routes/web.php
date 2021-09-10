<?php

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
//
//$date = new \DateTime('2019-08-01');
//echo date_format($date, 'F d, Y');

Route::middleware('auth')->group(function(){
    Route::resource('event', 'EventController');

    Route::get('/', 'EventController@index');

    Route::get('event', 'EventController@index')->name('event.index');

    Route::get('event/{event}/channel', 'ChannelController@create')->name('channel.create');

    Route::post('event/{event}/channel', 'ChannelController@store')->name('channel.store');

    Route::get('event/{event}/ticket', 'TicketController@create')->name('ticket.create');

    Route::post('event/{event}/ticket', 'TicketController@store')->name('ticket.store');

    Route::get('event/{event}/room', 'RoomController@create')->name('room.create');

    Route::post('event/{event}/room', 'RoomController@store')->name('room.store');

    Route::get('event/{event}/session', 'SessionController@create')->name('session.create');

    Route::post('event/{event}/session', 'SessionController@store')->name('session.store');

    Route::get('event/{event}/session/{session}', 'SessionController@edit')->name('session.edit');

    Route::put('event/{event}/session/{session}', 'SessionController@update')->name('session.update');

    Route::get('event/{event}/report', 'EventController@report')->name('event.report');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
