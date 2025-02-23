<?php

declare(strict_types=1);

namespace App\Modules\TelegramBot\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\TelegramBot\Domain\TelegramApiClientInterface;
use App\Modules\TelegramBot\Http\Requests\SetWebhookRequest;
use Illuminate\Http\JsonResponse;

class TelegramApiController extends Controller
{
    private TelegramApiClientInterface $telegramClient;

    public function __construct(TelegramApiClientInterface $telegramClient)
    {
        $this->telegramClient = $telegramClient;
    }

    /**
     * Устанавливает вебхук для Telegrambot.
     */
    public function setWebhook(SetWebhookRequest $request): JsonResponse
    {
        $url = $request->input('url');

        $result = $this->telegramClient->setWebhook($url);

        if (!$result['success']) {
            return response()->json([
                'ok'      => false,
                'error'   => 'Ошибка при установке вебхука',
                'details' => $result['error'],
            ], 500);
        }

        return response()->json([
            'ok'          => true,
            'data'        => [
                'url'               => $url,
                'telegram_response' => $result['data'],
            ],
            'description' => 'Webhook успешно установлен.',
        ]);
    }

    /**
     * Возвращает информацию о текущем адресе вебхука.
     */
    public function getWebhookInfo(): JsonResponse
    {
        $result = $this->telegramClient->getWebhookInfo();

        if (!$result['success']) {
            return response()->json([
                'ok'      => false,
                'error'   => 'Ошибка при получении информации о вебхуке',
                'details' => $result['error'],
            ], 500);
        }

        return response()->json([
            'ok'          => true,
            'data'        => [
                'telegram_response' => $result['data'],
            ],
            'description' => 'Информация о вебхуке успешно получена.',
        ]);
    }

    /**
     * Удаляет текущий URL для вебхука.
     */
    public function deleteWebhook(): JsonResponse
    {
        $result = $this->telegramClient->deleteWebhook();

        if (!$result['success']) {
            return response()->json([
                'ok'      => false,
                'error'   => 'Ошибка при удалении вебхука',
                'details' => $result['error'],
            ], 500);
        }

        return response()->json([
            'ok'          => true,
            'data'        => [
                'telegram_response' => $result['data'],
            ],
            'description' => 'Webhook успешно удален.',
        ]);
    }
}
