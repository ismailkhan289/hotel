<?php

use App\Http\Controllers;
use App\Http\Controllers\BookingController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test',function(){return "godfasdf";});
Route::get('/rooms/{rooms?}', \App\Http\Controllers\ShowRoomsController::class);
Route::resource('/bookings', \App\Http\Controllers\BookingController::class);