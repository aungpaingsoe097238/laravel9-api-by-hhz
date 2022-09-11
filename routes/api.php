<?php

use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\PhotoApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('products',ProductApiController::class);
Route::apiResource('photos',PhotoApiController::class);
