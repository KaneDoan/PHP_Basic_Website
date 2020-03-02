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


/*Route::get('/', function () {
    return view('dashboard');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});*/


/*Route::post('contact/submit','MessagesController@store');
Auth::routes();

Route::resource('messages','MessagesController');

Route::get('/dashboard', 'DashboardController@index');*/

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::resource('messages', 'MessagesController');
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');