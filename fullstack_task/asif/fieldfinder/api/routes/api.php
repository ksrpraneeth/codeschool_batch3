<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// user routes without token
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


// user routes with token
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/getUserDetails', [UserController::class, 'getUserDetails']);
Route::get('/checkSession', [UserController::class, 'checkSession']);


// getting venue related details
Route::get('/getVenues', [VenueController::class, 'getVenues']);
Route::get('/getCities', [VenueController::class, 'getCities']);
Route::get('/getSports', [VenueController::class, 'getSports']);
Route::get('/getVenueDetails', [VenueController::class, 'getVenueDetails']);
Route::get('/getTimeSlots', [VenueController::class, 'getTimeSlots']);