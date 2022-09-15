<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HireController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::group(['middleware' => ['auth:api']], function() {

    // User
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Hire
    Route::get('/hires', [HireController::class, 'index']); // all hires
    Route::post('/hire', [HireController::class, 'store']); // create hire
    Route::get('/hire/{id}', [HireController::class, 'show']); // get single hire
    Route::put('/hire/{id}', [HireController::class, 'update']); // update hire
    Route::delete('/hire/{id}', [HireController::class, 'destroy']); // delete hire
    //Route::get('/brand',[BrandController::class, 'show']);

    //brand
  

    Route::resource('/car','App\Http\Controllers\CarsController');

});
Route::get('/brand/{id}',[BrandController::class, 'show']); //get single brand
Route::get('/brands',[BrandController::class, 'display']);

Route::get('/cars',[CarsController::class, 'display']);
Route::get('/car/{id}', [CarsController::class, 'show']);

