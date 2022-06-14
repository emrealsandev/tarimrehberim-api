<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PlantsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\OrderController;


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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('products', ProductController::class);
    Route::resource('blogs', BlogController::class);
    Route::get('orders', [OrderController::class,'index']);
    Route::delete('order', [OrderController::class,'destroy']);
    Route::resource('plants',PlantsController::class)->except(['index']);
    Route::get('aplants', [PlantsController::class,'aIndex']);




    Route::post('/logout',[AuthController::class, 'logout']);

});
Route::get('/blog/view',[BlogController::class,'index']);
Route::get('/product/view', [ProductController::class,'index']);
Route::get('/product/view/{product_id}', [ProductController::class,'show']);
Route::get('plants', [PlantsController::class,'index']);
Route::post('/login',[AuthController::class, 'login']);
Route::post('/register',[AuthController::class, 'register']);
Route::post('order/{product_id}', [OrderController::class,'store']);



