<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\DashboardController;

Route::get('/low-stock', [DashboardController::class, 'getLowStock']);
Route::get('/best-sellers', [DashboardController::class, 'getBestSellers']);
Route::get('/total-penjualan', [DashboardController::class, 'getTotalPenjualan']);
Route::get('/total-products', [DashboardController::class, 'getTotalProducts']);
Route::get('/out-of-stock-products', [DashboardController::class, 'getOutOfStockProducts']);

//posts
Route::apiResource('/posts', PostController::class);
Route::apiResource('/products', ProductsController::class);
Route::apiResource('/transactions', TransactionController::class);
Route::apiResource('/users', UsersController::class);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::apiResource('/posts/delete/{id}', App\Http\Controllers\Api\PostController::class);
// Route::post('/posts', [PostController::class, 'store']);