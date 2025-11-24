<?php

namespace App\Services\Chat\Connectors;

use App\Services\Chat\AbstractChatConnector;

class ZaloConnector extends AbstractChatConnector
{
    protected function defaultHeaders(): array
    {
        return array_filter([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Zalo-OAID' => $this->credential('oa_id'),
            'X-Zalo-Access-Token' => $this->credential('access_token'),
        ]);
    }

    protected function formatSendPayload(string $conversationId, string $message, array $options = []): array
    {
        return [
            'recipient' => [
                'user_id' => $conversationId,
            ],
            'message' => [
                'text' => $message,
            ],
            'tracking_id' => $options['tracking_id'] ?? $this->id().'-'.now()->timestamp,
        ];
    }
}
