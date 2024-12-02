<?php

use App\Http\Controllers\Api\AstrologerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('astrologers')->group(function () {
    Route::get('/', [AstrologerController::class, 'index']);
    Route::post('/', [AstrologerController::class, 'store']);
    Route::get('/{astrologer}', [AstrologerController::class, 'show']);
    Route::put('/{astrologer}', [AstrologerController::class, 'update']);
    Route::delete('/{astrologer}', [AstrologerController::class, 'destroy']);
    Route::apiResource('astrologers', AstrologerController::class);
});
