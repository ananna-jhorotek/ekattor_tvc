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
    // return view('auth.login');
    return redirect('admin');
});
Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')
    ->name('login.provider')
    ->where('driver', implode('|', config('auth.socialite.drivers')));
Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')
    ->name('login.callback')
    ->where('driver', implode('|', config('auth.socialite.drivers')));
// Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
// Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();

Route::get('/admin', function () {
    return view('admin.home');
})->middleware('auth');

// Route::get('/programs', 'ProgramsController@index')->middleware('auth');
// Route::post('/programs', 'ProgramsController@store')->middleware('auth');

Route::get('/programs/bulk', 'ProgramsController@bulk_upload')->middleware('auth');
Route::get('programs/import', 'ProgramsController@import');
Route::post('programs/filter', 'ProgramsController@filter');
Route::resource('programs','ProgramsController')->middleware('auth');

Route::get('/commercials/?status={status}', 'CommercialsController@index')->middleware('auth');
Route::post('getBreaks', 'CommercialsController@getBreaks');
Route::get('commercials/export', 'CommercialsController@exportCreate');
Route::post('commercials/export', 'CommercialsController@export');
Route::get('commercials/import', 'CommercialsController@import_create');
Route::get('commercials/downloadSample', 'CommercialsController@downloadSample');
Route::post('commercials/import', 'CommercialsController@import_store');

Route::resource('commercials','CommercialsController')->middleware('auth');

Route::patch('/cal_events/{program}/index', 'Cal_eventController@index')->middleware('auth');
Route::get('/cal_events/destroyAll', 'Cal_eventController@destroyAll')->middleware('auth');
Route::patch('/commercial_cal_events/{commercial}/index', 'Commercial_cal_eventController@index')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
