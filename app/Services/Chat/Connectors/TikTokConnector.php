<?php

namespace App\Services\Chat\Connectors;

use App\Services\Chat\AbstractChatConnector;

class TikTokConnector extends AbstractChatConnector
{
    protected function defaultHeaders(): array
    {
        return array_filter([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-TTS-Access-Token' => $this->credential('access_token'),
            'X-TTS-App-Key' => $this->credential('app_key'),
            'X-TTS-Signature' => $this->signature(),
        ]);
    }

    protected function formatSendPayload(string $conversationId, string $message, array $options = []): array
    {
        return [
            'conversation_id' => $conversationId,
            'message_type' => 'text',
            'content' => [
                'text' => $message,
                'extras' => array_merge(['origin' => 'anonaddy'], $options),
            ],
        ];
    }

    private function signature(): ?string
    {
        $secret = $this->credential('app_secret');

        if (! $secret) {
            return null;
        }

        return hash_hmac('sha256', $this->id(), $secret);
    }
}
