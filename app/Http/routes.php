<?php 


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('/login');
});

Route::get('/login', 'UserController@getLogin');
Route::post('/login', 'UserController@postLogin');
Route::any('/logout', 'UserController@getLogout');

Route::get('/register', 'UserController@getRegistration');
Route::post('/register', 'UserController@postRegistration');

Route::any('/dashboard', 'DashboardController@getDashboard');

Route::get('/petition/edit/{id?}', 'DashboardController@getEditPetition');
Route::post('/petition/edit/{id?}', 'DashboardController@postEditPetition');

Route::get('/petition/sign/{id}', 'DashboardController@getSignPetition');
Route::post('/petition/sign/{id}', 'DashboardController@postSignPetition');

Route::any('/petition/thanks', 'DashboardController@getThanks');


Route::any('/petition/delete/{id}', 'DashboardController@deletePetition');

Route::any('/petition/view/{id}', 'DashboardController@getPetitionDetails');



