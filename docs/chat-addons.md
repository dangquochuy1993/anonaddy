# Chat Add-ons (TikTok, Shopee, Lazada, Zalo)

The chat add-on layer exposes a unified API surface for popular commerce and social platforms so you can view, sync, and respond to customer conversations directly from this service.

## Supported Platforms

- TikTok Shop
- Shopee Seller Chat
- Lazada Conversation
- Zalo OA Chat

Every connector shares the same capabilities:

| Capability | Description |
| --- | --- |
| List connectors | `GET /api/v1/chat/connectors` returns metadata, webhook URL, and configuration status. |
| Send message | `POST /api/v1/chat/connectors/{connector}/messages` sends a reply for the specified conversation. |
| Sync conversation | `POST /api/v1/chat/connectors/{connector}/sync` pulls the latest remote messages (supports `limit` and `since`). |
| Test | `POST /api/v1/chat/connectors/{connector}/test` performs a lightweight health check against the upstream API. |

Replace `{connector}` with one of `tiktok`, `shopee`, `lazada`, or `zalo`.

## Configuration

1. Copy the new `CHAT_*` variables from `.env.example` into your `.env` file.
2. Provide the credentials issued by each platform (app keys, partner IDs, OA secrets, etc.).
3. Set `CHAT_SIMULATE=false` once you are ready to call the real platform APIs. While `simulate` is true the system responds with mocked payloads so you can iterate quickly without valid tokens.
4. Optional: override the default endpoints if you need to target a sandbox cluster.

```env
CHAT_SIMULATE=false
CHAT_TIKTOK_APP_KEY=tt-key
CHAT_TIKTOK_APP_SECRET=tt-secret
CHAT_TIKTOK_ACCESS_TOKEN=tt-token
```

## Sample requests

Send a reply through Shopee:

```bash
curl -X POST https://app.example.com/api/v1/chat/connectors/shopee/messages \
  -H "Authorization: Bearer <personal-access-token>" \
  -d '{"conversation_id":"order-231","message":"Đã nhận thông tin, cảm ơn bạn!"}'
```

Trigger a conversation sync on Zalo:

```bash
curl -X POST https://app.example.com/api/v1/chat/connectors/zalo/sync \
  -H "Authorization: Bearer <personal-access-token>" \
  -d '{"conversation_id":"user-123","limit":20}'
```

## Error handling

- Missing or unknown connectors return `404`.
- Validation errors (missing `conversation_id`, empty `message`, etc.) surface as `422`.
- When the upstream API responds with an error the payload contains the HTTP status, response body, and headers for easier troubleshooting.

## Extending

Add additional providers by:

1. Creating a class under `App\Services\Chat\Connectors` that extends `AbstractChatConnector`.
2. Appending a new entry to `config/chat.php`.
3. Adding any extra environment variables to `.env.example`.

The `ChatConnectorManager` will automatically discover the new provider and expose it through the API without additional wiring.
