<?php

use App\Http\Controllers\IfscController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/ifsccode', [IfscController::class, "ifsccode"]);
Route::post('/agencydetails', [IfscController::class, "agencydetails"]);
Route::post('/searchagency', [IfscController::class, "searchagency"]);
Route::post('/updateagency/{agency}', [IfscController::class, "updateagency"]);
Route::post('/getforms', [IfscController::class, "getforms"]);
Route::post('/getformtype', [IfscController::class, "getformtype"]);
Route::post('/gethoaformtype', [IfscController::class, "gethoaformtype"]);
Route::post('/transactiondetails', [IfscController::class, "transactiondetails"]);
Route::post('/billDetails', [IfscController::class, "billDetails"]);
