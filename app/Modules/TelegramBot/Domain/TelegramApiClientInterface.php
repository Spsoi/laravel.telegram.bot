<?php

declare(strict_types=1);

namespace App\Modules\TelegramBot\Domain;

interface TelegramApiClientInterface
{
    public function setWebhook(string $url): array;
    public function getWebhookInfo(): array;
    public function deleteWebhook(): array;
}
