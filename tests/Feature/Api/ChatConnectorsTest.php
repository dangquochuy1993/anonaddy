<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ChatConnectorsTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        parent::setUpSanctum();

        $this->user->recipients()->save($this->user->defaultRecipient);

        config([
            'chat.simulate' => true,
            'chat.connectors.tiktok.credentials' => [
                'app_key' => 'key',
                'app_secret' => 'secret',
                'access_token' => 'token',
            ],
        ]);
    }

    /** @test */
    public function it_lists_all_supported_connectors()
    {
        $response = $this->json('GET', '/api/v1/chat/connectors');

        $response->assertSuccessful();
        $response->assertJsonCount(4, 'data');

        $tiktok = collect($response->json('data'))->firstWhere('id', 'tiktok');

        $this->assertTrue($tiktok['configured']);
    }

    /** @test */
    public function it_can_send_a_message_through_a_connector()
    {
        $payload = [
            'conversation_id' => 'order-123',
            'message' => 'Xin chào khách hàng!',
            'metadata' => ['channel' => 'support'],
        ];

        $response = $this->json('POST', '/api/v1/chat/connectors/tiktok/messages', $payload);

        $response->assertStatus(202);
        $response->assertJsonPath('data.connector', 'tiktok');
        $response->assertJsonPath('data.payload.content.text', 'Xin chào khách hàng!');
    }

    /** @test */
    public function it_can_sync_a_conversation()
    {
        $payload = [
            'conversation_id' => 'order-123',
            'limit' => 20,
        ];

        $response = $this->json('POST', '/api/v1/chat/connectors/tiktok/sync', $payload);

        $response->assertSuccessful();
        $response->assertJsonPath('data.connector', 'tiktok');
        $response->assertJsonPath('data.query.limit', 20);
    }

    /** @test */
    public function it_can_test_a_connector()
    {
        $response = $this->json('POST', '/api/v1/chat/connectors/tiktok/test', []);

        $response->assertSuccessful();
        $response->assertJsonPath('data.connector', 'tiktok');
        $response->assertTrue($response->json('data.simulated'));
    }

    /** @test */
    public function it_returns_404_for_unknown_connectors()
    {
        $response = $this->json('POST', '/api/v1/chat/connectors/unknown/messages', [
            'conversation_id' => 'missing',
            'message' => 'hello',
        ]);

        $response->assertStatus(404);
    }
}
