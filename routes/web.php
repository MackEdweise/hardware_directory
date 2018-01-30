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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function(){
    $app = app();
    if(!is_null(Auth::user())){
        $controller = $app->make('\App\Http\Controllers\HomeController');
    }
    else{
        $controller = $app->make('\App\Http\Controllers\GuestController');
    }
    return $controller->callAction('index', $parameters = array());
})->name('home');

Route::post('/add', 'DeviceController@add')->name('add_device');

Route::post('/edit', 'DeviceController@edit')->name('edit_device');

Route::post('/approve', 'DeviceController@approve')->name('approve_device');

Route::post('/upload', 'DeviceController@uploadCSV')->name('data_upload')->middleware('auth');

Route::get('/downloadSample', 'DeviceController@downloadSampleCSV')->name('data_sample_download')->middleware('auth');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('log_me_out');
