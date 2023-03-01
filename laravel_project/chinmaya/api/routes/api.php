<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\GameAvailibilityCheackController;


use App\Http\Controllers\SportsListController;
use App\Http\Controllers\SportstypeController;
use App\Http\Controllers\StadiumlistController;
use App\Http\Controllers\StatelistController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::post('/registration',[UserController::class,'register']);

Route::post('/login',[UserController::class,'login']);

Route::post('/dashbord',[DashbordController::class,'dashbord'])->middleware('guard');

Route::post('/groundlist',[StadiumlistController::class,'StadiumList']);

Route::post('/statelist',[StatelistController::class,'StateList']);

Route::post('/logout',[UserController::class,'Logout']);

Route::post('/sportstype',[sportstypeController::class,'SportsType']);

Route::post('/gameavailable',[gameAvailibilityCheackController::class,'GameAvailable']);

Route::post('/sportslist',[sportsListController::class,'SportsList']);

Route::get('/allStadium',[DashbordController::class,'allStadium']);

Route::post('/sports',[DashbordController::class,'Sports']);


Route::post('/availabletimeslot',[BookingController::class,'AvailableTimeSlot']);

Route::post('/bookground',[BookingController::class,'BookGround'])->middleware('guard');

Route::post('/bokking_history',[BookingController::class,'BookingHistory'])->middleware('guard');