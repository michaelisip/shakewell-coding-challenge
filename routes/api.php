<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vouchers\VoucherController;
use App\Http\Controllers\Vouchers\ApplicationController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health-check', function(Request $request) {
    return response()->json([
        'status' => 'OK',
        'timestamp' => Carbon::now()->format('F j, Y, g:i A')
    ]);
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function() {
    /** profile */
    Route::get('user', ProfileController::class);

    /** vouchers */
    Route::apiResource('vouchers', VoucherController::class);
    Route::post('vouchers/apply', [ApplicationController::class, 'apply']);
});
