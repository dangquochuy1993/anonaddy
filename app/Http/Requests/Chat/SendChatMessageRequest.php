<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class SendChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'conversation_id' => ['required', 'string', 'max:191'],
            'message' => ['required', 'string'],
            'metadata' => ['sometimes', 'array'],
        ];
    }

    public function conversationId(): string
    {
        return $this->input('conversation_id');
    }

    public function metadata(): array
    {
        return $this->input('metadata', []);
    }
}
