<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class TestChatConnectorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'context' => ['sometimes', 'array'],
        ];
    }

    public function context(): array
    {
        return $this->input('context', []);
    }
}
