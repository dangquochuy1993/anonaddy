<?php

use App\Services\Chat\Connectors\LazadaConnector;
use App\Services\Chat\Connectors\ShopeeConnector;
use App\Services\Chat\Connectors\TikTokConnector;
use App\Services\Chat\Connectors\ZaloConnector;

return [
    /*
    |--------------------------------------------------------------------------
    | Chat Connector Defaults
    |--------------------------------------------------------------------------
    |
    | `simulate` allows local development without calling remote commerce/social
    | APIs. When set to true every connector returns a mocked payload that
    | contains the HTTP verb, endpoint and payload that would have been sent.
    |
    */
    'simulate' => env('CHAT_SIMULATE', true),

    /*
    |--------------------------------------------------------------------------
    | HTTP timeout applied to every outbound connector request (in seconds)
    |--------------------------------------------------------------------------
    */
    'timeout' => env('CHAT_HTTP_TIMEOUT', 10),

    /*
    |--------------------------------------------------------------------------
    | Connector definitions
    |--------------------------------------------------------------------------
    |
    | Each connector describes the implementation class, credentials and API
    | endpoints that should be used when syncing or sending chat messages.
    |
    */
    'connectors' => [
        'tiktok' => [
            'label' => 'TikTok Shop',
            'class' => TikTokConnector::class,
            'base_uri' => env('CHAT_TIKTOK_BASE_URI', 'https://open-api.tiktokglobalshop.com'),
            'webhook' => env('CHAT_TIKTOK_WEBHOOK_URL'),
            'credentials' => [
                'app_key' => env('CHAT_TIKTOK_APP_KEY'),
                'app_secret' => env('CHAT_TIKTOK_APP_SECRET'),
                'access_token' => env('CHAT_TIKTOK_ACCESS_TOKEN'),
            ],
            'endpoints' => [
                'send' => env('CHAT_TIKTOK_SEND_ENDPOINT', '/api/chat/message/send'),
                'sync' => env('CHAT_TIKTOK_SYNC_ENDPOINT', '/api/chat/conversation/detail'),
                'ping' => env('CHAT_TIKTOK_PING_ENDPOINT', '/api/ping'),
            ],
        ],
        'shopee' => [
            'label' => 'Shopee Seller Chat',
            'class' => ShopeeConnector::class,
            'base_uri' => env('CHAT_SHOPEE_BASE_URI', 'https://partner.shopeemobile.com'),
            'webhook' => env('CHAT_SHOPEE_WEBHOOK_URL'),
            'credentials' => [
                'partner_id' => env('CHAT_SHOPEE_PARTNER_ID'),
                'partner_key' => env('CHAT_SHOPEE_PARTNER_KEY'),
                'access_token' => env('CHAT_SHOPEE_ACCESS_TOKEN'),
                'shop_id' => env('CHAT_SHOPEE_SHOP_ID'),
            ],
            'endpoints' => [
                'send' => env('CHAT_SHOPEE_SEND_ENDPOINT', '/api/v2/chat/send_message'),
                'sync' => env('CHAT_SHOPEE_SYNC_ENDPOINT', '/api/v2/chat/get_conversation_list'),
                'ping' => env('CHAT_SHOPEE_PING_ENDPOINT', '/api/v2/ping'),
            ],
        ],
        'lazada' => [
            'label' => 'Lazada Conversation',
            'class' => LazadaConnector::class,
            'base_uri' => env('CHAT_LAZADA_BASE_URI', 'https://api.lazada.com'),
            'webhook' => env('CHAT_LAZADA_WEBHOOK_URL'),
            'credentials' => [
                'app_key' => env('CHAT_LAZADA_APP_KEY'),
                'app_secret' => env('CHAT_LAZADA_APP_SECRET'),
                'access_token' => env('CHAT_LAZADA_ACCESS_TOKEN'),
            ],
            'endpoints' => [
                'send' => env('CHAT_LAZADA_SEND_ENDPOINT', '/rest/message/send'),
                'sync' => env('CHAT_LAZADA_SYNC_ENDPOINT', '/rest/message/list'),
                'ping' => env('CHAT_LAZADA_PING_ENDPOINT', '/rest/system/ping'),
            ],
        ],
        'zalo' => [
            'label' => 'Zalo OA Chat',
            'class' => ZaloConnector::class,
            'base_uri' => env('CHAT_ZALO_BASE_URI', 'https://openapi.zalo.me'),
            'webhook' => env('CHAT_ZALO_WEBHOOK_URL'),
            'credentials' => [
                'oa_id' => env('CHAT_ZALO_OA_ID'),
                'oa_secret' => env('CHAT_ZALO_OA_SECRET'),
                'access_token' => env('CHAT_ZALO_ACCESS_TOKEN'),
            ],
            'endpoints' => [
                'send' => env('CHAT_ZALO_SEND_ENDPOINT', '/v3.0/oa/message'),
                'sync' => env('CHAT_ZALO_SYNC_ENDPOINT', '/v3.0/oa/conversation'),
                'ping' => env('CHAT_ZALO_PING_ENDPOINT', '/v3.0/oa/getoa'),
            ],
        ],
    ],
];
