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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/gebruiker', 'GebruikerController@index')->name('home');
Route::get('/gebruiker/{user}', 'GebruikerController@show')->name('gebruiker.show');

Route::resource('/administrator/gebruikersprofielen','GebruikersprofielController');
