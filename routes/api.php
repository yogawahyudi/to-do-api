<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Checklist\ChecklistController;
use App\Http\Controllers\Checklist\ChecklistItemController;
use App\Models\checklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    // Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::prefix('checklist')->group(function () {
        Route::get('/', [ChecklistController::class, 'index']);
        Route::post('/', [ChecklistController::class, 'store']);
        Route::delete('{id}', [ChecklistController::class, 'destroy']);
        Route::prefix('{checklistId}/item')->group(function () {
            Route::get('/', [ChecklistItemController::class, 'index']);
            Route::post('/', [ChecklistItemController::class, 'store']);
            Route::put('rename/{checklistItemId}', [ChecklistItemController::class, 'rename']);
            Route::get('{checklistItemId}', [ChecklistItemController::class, 'show']);
            Route::put('{checklistItemId}', [ChecklistItemController::class, 'update']);
            Route::delete('{checklistItemId}', [ChecklistItemController::class, 'destroy']);
        });
    });
});