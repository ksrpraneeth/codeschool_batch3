<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\recipeController;
use App\Http\Controllers\RegisterController;
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

    Route::post('/addrecipe', [recipeController::class, "addrecipe"]);
    Route::post('/getrecipes', [recipeController::class, "getrecipes"]);
    Route::post('/recipedetails', [recipeController::class, "recipedetails"]);
    Route::post('/deleterecipe', [recipeController::class, "deleteRecipe"]);
    Route::post('/saveRequest/{recipeModel}', [recipeController::class, "saveRequest"]);
    Route::post('/addingredient', [recipeController::class, "addIngredient"]);
    Route::post('/getingredient', [recipeController::class, "getingredients"]);
    Route::post('/selectedingredient', [recipeController::class, "selectedingredient"]);
    Route::post('/registeruser', [RegisterController::class, "registeruser"]);
    Route::post('/loginuser', [RegisterController::class, "loginuser"]);

    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/dashboard', [RegisterController::class, "dashboard"]);