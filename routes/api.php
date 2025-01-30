<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanicController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('/sendPanic', [PanicController::class, 'sendPanic']);
    Route::get('/getPanic', [PanicController::class, 'getPanic']);
    Route::put('/cancelPanic/{id}', [PanicController::class, 'cancelPanic']);
});
