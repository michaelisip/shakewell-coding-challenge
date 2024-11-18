<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function(Request $request) {
    return response()->json([
        'message' => 'Ok'
    ]);
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('vouchers', VoucherController::class);
});
