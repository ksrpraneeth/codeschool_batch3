<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
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
    Route::get("/logout", function () {
        return response()->json([
            "status" => false,
            "message" => "LOGOUT"
        ]);
    });
});

Route::group(["prefix" => "user", "middleware" => "auth"], function () {
    Route::get("/get", [UserController::class, "get"]);
    Route::get("/getModules", [UserController::class, "getModules"]);
    Route::get("/getEmployees", [UserController::class, "getEmployees"]);
});
Route::get("/module/{module}", [ModuleController::class, 'getModule'])->middleware("auth");

