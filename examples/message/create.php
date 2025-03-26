<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 创建一个新的消息
$conversationId = '7485929034791075891'; // 使用刚创建的有效会话ID
$response = $coze->message()->create(
    $conversationId,
    'Hello, this is a test message from SDK',
    'text',
    'user',
    'question'
);

// 输出响应
echo "创建消息响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 获取消息ID
$messageId = $response->json('data.id');
echo "消息ID: {$messageId}\n";
