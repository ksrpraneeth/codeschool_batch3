<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\FormNumberController;
use App\Http\Controllers\IfscCodeController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
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

Route::group(["prefix" => "ifsc-code"], function () {
    Route::post("get-by-code", [IfscCodeController::class, 'getByCode']);
});

Route::group(["prefix" => "agencies"], function () {
    Route::post("get-by-account-number", [AgencyController::class, 'getAgencyByAcNo']);
    Route::post("", [AgencyController::class, 'createAgency']);
    Route::put("{agency}", [AgencyController::class, 'updateAgency']);
});

Route::group(["prefix" => "form-numbers"], function () {
    Route::get("", [FormNumberController::class, "getAll"]);
    Route::get("{formNumber}/form-types", [FormNumberController::class, "getFormTypes"]);
    Route::get("/form-types/{formType}/hoas", [FormNumberController::class, "getHeadOfAccounts"]);
    Route::get("/form-types/{formType}/scrutiny-items", [FormNumberController::class, "getScrutinyItems"]);
});

Route::group(["prefix" => "transactions"], function () {
    Route::post("", [TransactionController::class, "createTransaction"]);
    Route::post("get-by-tbr-no", [TransactionController::class, "getBill"]);
});
