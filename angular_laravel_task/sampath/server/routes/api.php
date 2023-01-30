<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\UserController;
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

Route::group(["prefix" => "user"], function () {
    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);
    Route::get("/get", [UserController::class, "get"])->middleware('auth');
    Route::get("/logout", function () {
        return response()->json([
            "status" => false,
            "message" => "LOGOUT"
        ]);
    });
    Route::get("/logoutUser", [AuthController::class, "logout"]);
});

Route::apiResource("employees", EmployeeController::class)->only([
    'index', 'show', 'update', 'store'
])->middleware('auth');
Route::apiResource("employees.salaries", SalaryController::class)->only([
    'index', 'show', 'update', 'store'
])->middleware('auth');

