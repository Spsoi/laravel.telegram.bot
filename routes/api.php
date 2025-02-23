<?php

declare(strict_types=1);

use App\Modules\TelegramBot\Http\Controllers\TelegramApiController;
use App\Modules\TelegramBot\Http\Controllers\TelegramWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('telegram')->group(function () {
    Route::post('setWebhook', [TelegramApiController::class, 'setWebhook']);
    Route::get('getWebhookInfo', [TelegramApiController::class, 'getWebhookInfo']);
    Route::post('deleteWebhook', [TelegramApiController::class, 'deleteWebhook']);
    Route::get('getUpdates', [TelegramApiController::class, 'getUpdates']);
    Route::post('webhook', [TelegramWebhookController::class, 'handle']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
