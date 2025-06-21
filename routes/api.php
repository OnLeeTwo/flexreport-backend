<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Protected report routes
    Route::get('/reports/tables', [ReportController::class, 'getTables']);
    Route::get('/reports/columns/{table}', [ReportController::class, 'getColumns']);
    Route::get('/reports/column-values/{table}/{column}', [ReportController::class, 'getColumnValues']);
    Route::post('/reports/generate', [ReportController::class, 'generate']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/templates', [TemplateController::class, 'index']);
    Route::post('/templates', [TemplateController::class, 'store']);
    Route::get('/templates/{id}', [TemplateController::class, 'show']);
    Route::delete('/templates/{id}', [TemplateController::class, 'destroy']);
});
