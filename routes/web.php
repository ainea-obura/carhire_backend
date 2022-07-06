<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
// Category
Route::resource('/category','App\Http\Controllers\CategoryController');
//brand
Route::resource('brand', 'App\Http\Controllers\BrandController');
//cars
Route::resource('/car','App\Http\Controllers\CarsController');

Route::get('/file-manager',function(){
    return view('layouts.file-manager');
})->name('file-manager');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

