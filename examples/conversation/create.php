<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $coze->conversation()->create([
    'bot_id' => '7484523878849822754',
    'messages' => [
        [
            'uuid' => 'initial_message_'.time(),
            'role' => 'user',
            'content' => '你好，这是一个测试消息',
        ],
    ],
    'meta_data' => [
        'custom_field' => 'test_value',
    ],
]);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
