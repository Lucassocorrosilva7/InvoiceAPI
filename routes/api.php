<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\InvoiceController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{users}', [UserController::class, 'show']);
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::get('/invoices/{invoce}', [InvoiceController::class, 'show']);
    Route::post('/invoices', [InvoiceController::class, 'store']);
    Route::put('/invoices/{invoce}', [InvoiceController::class, 'update']);
});
