<?php

namespace App\Services\Chat;

use App\Contracts\ChatConnector;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class ChatConnectorManager
{
    /**
     * @var array<string, mixed>
     */
    protected array $config;

    /**
     * @var array<string, ChatConnector>
     */
    protected array $instances = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Return all connector instances.
     *
     * @return ChatConnector[]
     */
    public function all(): array
    {
        return collect(array_keys($this->config['connectors'] ?? []))
            ->map(fn ($key) => $this->connector($key))
            ->all();
    }

    public function connector(string $key): ChatConnector
    {
        $definition = $this->config['connectors'][$key] ?? null;

        if (! $definition) {
            throw new InvalidArgumentException("Chat connector [{$key}] is not defined.");
        }

        if (! isset($this->instances[$key])) {
            $class = $definition['class'] ?? null;

            if (! $class || ! class_exists($class)) {
                throw new InvalidArgumentException("Chat connector [{$key}] must define a valid class.");
            }

            $connectorConfig = array_merge(
                Arr::only($this->config, ['simulate', 'timeout']),
                $definition
            );

            $this->instances[$key] = new $class($key, $connectorConfig);
        }

        return $this->instances[$key];
    }
}
