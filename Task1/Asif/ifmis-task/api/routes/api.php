<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BillEntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Agency Routes
Route::post('/checkBankAccount', [AgencyController::class, 'checkBankAccount']);

Route::post('/getBankDetails', [AgencyController::class, 'getBankDetails']);

Route::post('/addAgencyDetails', [AgencyController::class, 'addAgencyDetails']);

Route::post('/getAgencyDetails', [AgencyController::class, 'getAgencyDetails']);

Route::post('/updateAgencyDetails', [AgencyController::class, 'updateAgencyDetails']);




// Bill Entry Routes
Route::get('/getFormNumbers', [BillEntryController::class, 'getFormNumbers']);

Route::get('/getFormTypes', [BillEntryController::class, 'getFormTypes']);

Route::post('/getScrutinyItems', [BillEntryController::class, 'getScrutinyItems']);