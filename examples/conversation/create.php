<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 创建一个新的会话
$response = $coze->conversation()->create([
    'bot_id' => '7484523878849822754', // 可选，指定机器人ID
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

// 输出响应
echo "创建会话响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 获取会话ID
$conversationId = $response->json('data.id');
echo "会话ID: {$conversationId}\n";
