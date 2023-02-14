<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\IfscCodeController;
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

Route::group(["prefix" => "ifscCode"], function () {
    Route::post("getByCode", [IfscCodeController::class, 'getByCode']);
});

Route::group(["prefix" => "agency"], function () {
    Route::post("getByAccountNumber", [AgencyController::class, 'getAgencyByAcNo']);
    Route::post("create", [AgencyController::class, 'createAgency']);
    Route::post("update/{agency}", [AgencyController::class, 'updateAgency']);
});
