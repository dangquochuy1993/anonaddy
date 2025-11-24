<?php

namespace App\Contracts;

interface ChatConnector
{
    /**
     * Machine readable connector identifier (e.g. tiktok/shopee).
     */
    public function id(): string;

    /**
     * Human readable label.
     */
    public function label(): string;

    /**
     * Optional webhook endpoint URL that can be configured per connector.
     */
    public function webhookUrl(): ?string;

    /**
     * Determine if the connector has the required credentials to operate.
     */
    public function isConfigured(): bool;

    /**
     * Lightweight metadata suitable for surfacing in the API/UI.
     */
    public function metadata(): array;

    /**
     * Call the platform health/ping endpoint.
     */
    public function testConnection(array $context = []): array;

    /**
     * Pull the most recent conversation messages from the platform.
     */
    public function sync(string $conversationId, array $options = []): array;

    /**
     * Push a new message into the remote platform.
     */
    public function send(string $conversationId, string $message, array $options = []): array;
}
