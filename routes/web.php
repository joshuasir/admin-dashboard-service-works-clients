<?php

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
Route::get('/', function(){
    return view('welcome');
});


// Route::get('/getData','App\Http\Controllers\PagesController@getData');
// Route::get('/index/{cat}', 'App\Http\Controllers\PagesController@index');
// Route::post('/index/{cat}', 'App\Http\Controllers\PagesController@index');
// Route::post('/findword/{cat}', 'App\Http\Controllers\PagesController@getData');

// Route::get('/login', 'App\Http\Controllers\PagesController@login');
 


Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/index/{tab}', 'App\Http\Controllers\PagesController@index');

Route::get('/index', 'App\Http\Controllers\PagesController@index');
    Route::resource('/works','App\Http\Controllers\WorksController');
    Route::post('/client', 'App\Http\Controllers\ClientController@store');
    Route::delete('/client/{id}', 'App\Http\Controllers\ClientController@destroy');

    Route::get('/index/services','App\Http\Controllers\ServicesController@index');
    Route::post('/services','App\Http\Controllers\ServicesController@store');
    Route::post('/services/{id}','App\Http\Controllers\ServicesController@update');
    Route::delete('/services/{id}', 'App\Http\Controllers\ServicesController@destroy');

    Route::post('/work_visible/{id}','App\Http\Controllers\WorksController@updateVisibility');
    Route::post('/client_visible/{id}', 'App\Http\Controllers\ClientController@updateVisibility');
    Route::post('/service_visible/{id}', 'App\Http\Controllers\ServicesController@updateVisibility');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
