<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\PhotoApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register',[AuthApiController::class,'register'])->name('api.register');
Route::post('login',[AuthApiController::class,'login'])->name('api.login');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('logout',[AuthApiController::class,'logout'])->name('api.logout');
    Route::get('tokens',[AuthApiController::class,'tokens'])->name('api.tokens');
    Route::apiResource('products',ProductApiController::class);
    Route::apiResource('photos',PhotoApiController::class);
});

