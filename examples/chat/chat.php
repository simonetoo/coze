<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 发送聊天消息
$response = $coze->chat()->chat(
    '7484523878849822754', // 机器人ID
    'test_user_123',       // 用户ID
    [
        'auto_save_history' => true,
        'stream' => false,
        'messages' => [
            [
                'role' => 'user',
                'content' => '你好，请介绍一下自己',
            ],
        ],
    ]
);

// 输出响应
echo "发送聊天消息响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 如果聊天成功，打印聊天ID和会话ID
if ($response->json('code') === 0) {
    $chatId = $response->json('data.id');
    $conversationId = $response->json('data.conversation_id');
    echo "聊天ID: {$chatId}\n";
    echo "会话ID: {$conversationId}\n";
}
