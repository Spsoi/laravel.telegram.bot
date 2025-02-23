<?php

declare(strict_types=1);

namespace App\Modules\TelegramBot\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetWebhookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['required', 'url', 'regex:/^https:\/\//i'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
