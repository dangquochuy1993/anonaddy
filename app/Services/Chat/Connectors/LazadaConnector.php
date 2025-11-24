<?php

namespace App\Services\Chat\Connectors;

use App\Services\Chat\AbstractChatConnector;

class LazadaConnector extends AbstractChatConnector
{
    protected function defaultHeaders(): array
    {
        return array_filter([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Lazada-App-Key' => $this->credential('app_key'),
            'X-Lazada-Signature' => $this->signature(),
            'Authorization' => $this->accessToken(),
        ]);
    }

    protected function formatSendPayload(string $conversationId, string $message, array $options = []): array
    {
        return [
            'conversation_id' => $conversationId,
            'payload' => [
                'text' => $message,
                'attachments' => $options['attachments'] ?? [],
            ],
        ];
    }

    private function signature(): ?string
    {
        $secret = $this->credential('app_secret');

        if (! $secret) {
            return null;
        }

        return hash('sha256', $secret.$this->id());
    }

    private function accessToken(): ?string
    {
        $token = $this->credential('access_token');

        return $token ? 'Bearer '.$token : null;
    }
}
