<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Sales\SalesController;

Route::post('login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [AuthController::class, 'me'])->name('me');
});

// Route::middleware(['auth:sanctum'])->prefix('sales')->controller(SalesController::class)->group(function () {
//     Route::get('/', 'index');
//     Route::post('/create', 'store');
// });

Route::get('sales', [SalesController::class, 'index']);
Route::post('sales/create', [SalesController::class, 'store']);
Route::put('sales/edit/{id}', [SalesController::class, 'edit']);
