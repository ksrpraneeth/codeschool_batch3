<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductdetailsController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\myOrderController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// }); 
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::group([

    'middleware' => 'jwt'

], function ($router) {

    Route::get('/product',[ProductController::class,"product_list"]);
    Route::get('/productDetails',[ProductdetailsController::class,"product_details"]);
    Route::get('/userAddress',[UserAddressController::class,"user_address"]);
    Route::post('/order',[OrderController::class,"order"]);
    Route::get('/myOrder',[myOrderController::class,"myOrder"]);

}); 




// Route::middleware('auth:sanctum')->post('/product',
// [ProductController::class,"product_list"]);

