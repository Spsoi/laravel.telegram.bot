<?php

declare(strict_types=1);

namespace App\Modules\TelegramBot\Http\Controllers;

use App\Modules\TelegramBot\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramWebhookController extends Controller
{
    private string $telegramApiBaseUrl;

    public function __construct()
    {
        $this->telegramApiBaseUrl = "https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN');
    }

    /**
     * Обрабатывает входящее обновление от Telegram.
     */
    public function handle(Request $request): JsonResponse
    {
        $update = $request->all();
        Log::info('Telegram Update:', $update);

        if (isset($update['message']['photo'])) {
            $photoArray = $update['message']['photo'];
            $bestPhoto  = end($photoArray);
            $fileId     = $bestPhoto['file_id'];

            $this->sendPhotoToAdmin($fileId);
        }

        return response()->json([
            'status'  => 'ok',
            'message' => 'Update processed',
        ]);
    }

    /**
     * Отправляет фотографию админу бота по заданному chat_id.
     *
     * @param string $fileId
     */
    protected function sendPhotoToAdmin(string $fileId): void
    {
        $adminChatId = env('TELEGRAM_ADMIN_CHAT_ID');
        $telegramApiUrl = $this->telegramApiBaseUrl . "/sendPhoto";
        $response = Http::post($telegramApiUrl, [
            'chat_id' => $adminChatId,
            'photo'   => $fileId,
            'caption' => 'Получено новое изображение'
        ]);

        Log::info('Send photo response:', $response->json());
    }
}
