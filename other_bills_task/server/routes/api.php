<?php

use App\Http\Controllers\IfmisController;
use App\Http\Requests\getIfscCodeDetailsRequest;
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

Route::post('/getIfscCodeDetails', [IfmisController::class, 'getIfscCodeDetails']);
Route::post('/addAgency', [IfmisController::class, 'addAgency']);
Route::post('/getAgency', [IfmisController::class, 'getAgency']);
Route::post('/editAgency/{agency}', [IfmisController::class, 'editAgency']);
Route::post('/getFormNumber', [IfmisController::class, 'getFormNumber']);
Route::post('/getFormType', [IfmisController::class, 'getFormType']);
Route::post('/getHoaScrutinyItems', [IfmisController::class, 'getHoaScrutinyItems']);
Route::post('/submitBill', [IfmisController::class, 'submitBill']);
Route::post('/getTransactionDetails', [IfmisController::class, 'getTransactionDetails']);