<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AthenticateController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AthenticateController::class, 'register'])->name('api.register');
Route::post('login', [AthenticateController::class, 'login'])->name('api.login');
Route::get('refresh', [AthenticateController::class, 'refresh'])->name('api.token.refresh');

    // Product
Route::group(['middleware' => ['api','auth'],'prefix' => 'product'],function (){
    Route::post('create',[ProductController::class,'create'])->name('product.create');
    Route::get('all',[ProductController::class,'all'])->name('product.all');
    Route::post('update/{product}',[ProductController::class,'update'])->name('product.update');
    Route::get('show/{product}',[ProductController::class,'show'])->name('product.show');
    Route::post('delete/{product}',[ProductController::class,'delete'])->name('product.delete');
});

    // Order
Route::group(['middleware' => ['api','auth'],'prefix' => 'order'],function (){
    Route::post('create',[OrderController::class,'create'])->name('order.create');
    Route::get('all',[OrderController::class,'all'])->name('order.all');
    Route::post('update/{order}',[OrderController::class,'update'])->name('order.update');
    Route::get('show/{order}',[OrderController::class,'show'])->name('order.show');
    Route::post('delete/{order}',[OrderController::class,'delete'])->name('order.delete');
});