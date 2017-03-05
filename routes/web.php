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

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
	Route::get('/home', 'HomeController@index');

	Route::resource('/label', 'LabelController');

	Route::resource('/note', 'NoteController');

	Route::get('/rest/note', 'HomeController@restNote');

	Route::get('/mark-this/{id}', 'HomeController@markThis');

	Route::get('/rest/upcoming-note', 'HomeController@getUpcomingNotes');

	Route::get('/rest/got-this-note/{id}', 'HomeController@gotThis');
});