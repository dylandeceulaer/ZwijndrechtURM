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
Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/gebruiker', 'GebruikerController@index')->name('home');
Route::get('/gebruiker/{user}', 'GebruikerController@show')->name('gebruiker.show');

Route::get('/administrator','AdministratorController@index');
Route::get('/administrator/gebruikersprofielen/{id}/toepassingen','GebruikersprofielController@showToepassingen')->middleware('can:viewAny,App\Gebruikersprofiel');
Route::get('/administrator/gebruikersprofielen/{id}/gebruikers','GebruikersprofielController@showgebruikers')->middleware('can:viewAny,App\Gebruikersprofiel');
Route::resource('/administrator/toepassingen','ToepassingController')->middleware('can:viewAny,App\Gebruikersprofiel');
Route::resource('/administrator/gebruikersprofielen','GebruikersprofielController')->middleware('can:viewAny,App\Gebruikersprofiel');