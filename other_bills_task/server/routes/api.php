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

Route::group(["prefix" => "ifscCode"], function () {
    Route::post("getByCode", [IfscCodeController::class, 'getByCode']);
});

Route::group(["prefix" => "agency"], function () {
    Route::post("getByAccountNumber", [AgencyController::class, 'getAgencyByAcNo']);
    Route::post("create", [AgencyController::class, 'createAgency']);
    Route::post("update/{agency}", [AgencyController::class, 'updateAgency']);
});

Route::group(["prefix" => "formNumber"], function () {
    Route::get("all", [FormNumberController::class, "getAll"]);
    Route::get("{formNumber}/formTypes", [FormNumberController::class, "getFormTypes"]);
    Route::get("/formType/{formType}/hoas", [FormNumberController::class, "getHeadOfAccounts"]);
    Route::get("/formType/{formType}/scrutinyItems", [FormNumberController::class, "getScrutinyItems"]);
});

Route::group(["prefix" => "transaction"], function () {
    Route::post("/create", [TransactionController::class, "createTransaction"]);
    Route::post("/view", [TransactionController::class, "getBill"]);
});