<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class SyncChatConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'conversation_id' => ['required', 'string', 'max:191'],
            'limit' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'since' => ['sometimes', 'string'],
        ];
    }

    public function conversationId(): string
    {
        return $this->input('conversation_id');
    }

    public function options(): array
    {
        return $this->only(['limit', 'since']);
    }
}
