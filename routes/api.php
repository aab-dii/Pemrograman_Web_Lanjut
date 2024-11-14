<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//posts
Route::apiResource('/posts', PostController::class);
Route::apiResource('/products', ProductsController::class);
Route::apiResource('/transactions', TransactionController::class);
// Route::apiResource('/posts/delete/{id}', App\Http\Controllers\Api\PostController::class);
// Route::post('/posts', [PostController::class, 'store']);