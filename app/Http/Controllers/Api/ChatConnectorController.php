<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ChatConnector;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SendChatMessageRequest;
use App\Http\Requests\Chat\SyncChatConversationRequest;
use App\Http\Requests\Chat\TestChatConnectorRequest;
use App\Services\Chat\ChatConnectorManager;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class ChatConnectorController extends Controller
{
    public function __construct(
        protected readonly ChatConnectorManager $manager
    ) {
    }

    public function index(): JsonResponse
    {
        $connectors = collect($this->manager->all())->map(function (ChatConnector $connector) {
            return [
                'id' => $connector->id(),
                'label' => $connector->label(),
                'webhook' => $connector->webhookUrl(),
                'configured' => $connector->isConfigured(),
                'metadata' => $connector->metadata(),
            ];
        });

        return response()->json(['data' => $connectors]);
    }

    public function send(SendChatMessageRequest $request, string $connector): JsonResponse
    {
        $instance = $this->resolve($connector);

        $result = $instance->send(
            $request->conversationId(),
            $request->input('message'),
            $request->metadata()
        );

        return response()->json(['data' => $result], Response::HTTP_ACCEPTED);
    }

    public function sync(SyncChatConversationRequest $request, string $connector): JsonResponse
    {
        $instance = $this->resolve($connector);

        $result = $instance->sync(
            $request->conversationId(),
            $request->options()
        );

        return response()->json(['data' => $result]);
    }

    public function test(TestChatConnectorRequest $request, string $connector): JsonResponse
    {
        $instance = $this->resolve($connector);

        $result = $instance->testConnection($request->context());

        return response()->json(['data' => $result]);
    }

    protected function resolve(string $connector): ChatConnector
    {
        try {
            return $this->manager->connector($connector);
        } catch (InvalidArgumentException $exception) {
            abort(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }
    }
}
