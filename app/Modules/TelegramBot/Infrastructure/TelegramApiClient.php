<?php

declare(strict_types=1);

namespace App\Modules\TelegramBot\Infrastructure;

use App\Modules\TelegramBot\Domain\TelegramApiClientInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramApiClient implements TelegramApiClientInterface
{
    private string $telegramApiBaseUrl;

    public function __construct()
    {
        $token = config('telegram.bot_token');
        if (!$token) {
            throw new \InvalidArgumentException('TELEGRAM_BOT_TOKEN не сконфигурирован');
        }
        $this->telegramApiBaseUrl = "https://api.telegram.org/bot" . $token;
    }

    public function setWebhook(string $url): array
    {
        return $this->callTelegramApi('setWebhook', ['url' => $url]);
    }

    public function getWebhookInfo(): array
    {
        return $this->callTelegramApi('getWebhookInfo');
    }

    public function deleteWebhook(): array
    {
        return $this->callTelegramApi('deleteWebhook');
    }

    private function callTelegramApi(string $endpoint, array $data = []): array
    {
        try {
            $url = $this->telegramApiBaseUrl . '/' . $endpoint;
            $response = empty($data) ? Http::get($url) : Http::post($url, $data);

            if (!$response->successful()) {
                Log::error("Ошибка Telegram API: " . $response->body());
                return [
                    'success' => false,
                    'error'   => $response->json() ?: $response->body()
                ];
            }

            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error("Исключение при вызове Telegram API: " . $e->getMessage());
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
