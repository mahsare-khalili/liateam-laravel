<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AthenticateController;
use App\Http\Controllers\Api\ProductController;

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

Route::group(['middleware' => ['api','auth'],'prefix' => 'product'],function (){
    // Product
    Route::post('create',[ProductController::class,'create'])->name('product.create');
    Route::get('all',[ProductController::class,'all'])->name('product.all');
    Route::post('update/{product}',[ProductController::class,'update'])->name('product.update');
    Route::get('show/{product}',[ProductController::class,'show'])->name('product.show');
    Route::post('delete/{product}',[ProductController::class,'delete'])->name('product.delete');
});