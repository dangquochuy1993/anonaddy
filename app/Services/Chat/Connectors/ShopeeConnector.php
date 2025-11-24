<?php

namespace App\Services\Chat\Connectors;

use App\Services\Chat\AbstractChatConnector;

class ShopeeConnector extends AbstractChatConnector
{
    protected function defaultHeaders(): array
    {
        return array_filter([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $this->accessToken(),
            'X-Shopee-Partner-Id' => $this->credential('partner_id'),
            'X-Shopee-Shop-Id' => $this->credential('shop_id'),
        ]);
    }

    protected function formatSendPayload(string $conversationId, string $message, array $options = []): array
    {
        return [
            'conversation_id' => $conversationId,
            'message' => $message,
            'type' => 'text',
            'extra' => array_merge([
                'partner_id' => $this->credential('partner_id'),
                'shop_id' => $this->credential('shop_id'),
            ], $options),
        ];
    }

    private function accessToken(): ?string
    {
        $token = $this->credential('access_token');

        if (! $token) {
            return null;
        }

        return 'Bearer '.$token;
    }
}
