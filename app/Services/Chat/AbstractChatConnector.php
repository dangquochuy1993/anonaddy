<?php

namespace App\Services\Chat;

use App\Contracts\ChatConnector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

abstract class AbstractChatConnector implements ChatConnector
{
    protected bool $simulate;

    public function __construct(
        protected readonly string $key,
        protected array $config = []
    ) {
        $this->simulate = (bool) Arr::get($config, 'simulate', true);
    }

    public function id(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->config['label'] ?? Str::headline($this->key);
    }

    public function webhookUrl(): ?string
    {
        return Arr::get($this->config, 'webhook');
    }

    public function isConfigured(): bool
    {
        $credentials = Arr::get($this->config, 'credentials', []);

        if (empty($credentials)) {
            return false;
        }

        $filled = collect($credentials)->filter(fn ($value) => filled($value));

        return $filled->count() === count($credentials);
    }

    public function metadata(): array
    {
        return [
            'base_uri' => Arr::get($this->config, 'base_uri'),
            'webhook' => $this->webhookUrl(),
            'simulate' => $this->simulate,
        ];
    }

    public function testConnection(array $context = []): array
    {
        return $this->sendRequest(
            'GET',
            Arr::get($this->config, 'endpoints.ping', '/ping'),
            [],
            array_merge(['healthcheck' => true], $context)
        );
    }

    public function sync(string $conversationId, array $options = []): array
    {
        return $this->sendRequest(
            'GET',
            Arr::get($this->config, 'endpoints.sync', '/conversations'),
            [],
            $this->formatSyncQuery($conversationId, $options)
        );
    }

    public function send(string $conversationId, string $message, array $options = []): array
    {
        return $this->sendRequest(
            'POST',
            Arr::get($this->config, 'endpoints.send', '/messages'),
            $this->formatSendPayload($conversationId, $message, $options)
        );
    }

    /**
     * Convert the platform specific payload for outbound messages.
     */
    protected function formatSendPayload(string $conversationId, string $message, array $options = []): array
    {
        return [
            'conversation_id' => $conversationId,
            'message' => [
                'text' => $message,
                'metadata' => $options,
            ],
        ];
    }

    /**
     * Convert the platform specific query parameters for sync operations.
     */
    protected function formatSyncQuery(string $conversationId, array $options = []): array
    {
        return array_merge([
            'conversation_id' => $conversationId,
        ], Arr::only($options, ['limit', 'since']));
    }

    /**
     * Basic headers used by every connector, can be extended per implementation.
     */
    abstract protected function defaultHeaders(): array;

    protected function credential(string $key): ?string
    {
        return Arr::get($this->config, "credentials.{$key}");
    }

    protected function sendRequest(string $method, string $endpoint, array $payload = [], array $query = []): array
    {
        if ($this->simulate || ! $this->isConfigured()) {
            return $this->fakeResponse($method, $endpoint, $payload, $query);
        }

        try {
            $response = Http::baseUrl($this->config['base_uri'])
                ->timeout($this->config['timeout'] ?? 10)
                ->withHeaders($this->defaultHeaders())
                ->send($method, ltrim($endpoint, '/'), [
                    'json' => $payload,
                    'query' => $query,
                ]);

            return [
                'status' => $response->status(),
                'body' => $response->json(),
                'headers' => $response->headers(),
            ];
        } catch (Throwable $exception) {
            return [
                'status' => 500,
                'error' => $exception->getMessage(),
            ];
        }
    }

    protected function fakeResponse(string $method, string $endpoint, array $payload, array $query): array
    {
        return [
            'status' => 202,
            'simulated' => true,
            'connector' => $this->id(),
            'method' => strtoupper($method),
            'endpoint' => $endpoint,
            'payload' => $payload,
            'query' => $query,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
