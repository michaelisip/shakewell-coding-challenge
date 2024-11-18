<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\VoucherController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/health', function(Request $request) {
    return response()->json([
        'message' => 'Ok'
    ]);
});

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {
    Route::resource('vouchers', VoucherController::class);
});
