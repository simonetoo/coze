<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 聊天ID和会话ID
$chatId = '7485914486474407999'; // 使用刚刚创建的聊天ID
$conversationId = '7485914486474375231'; // 使用刚刚创建的会话ID

// 获取聊天详情
$response = $coze->chat()->retrieve($chatId, $conversationId);

// 输出响应
echo "获取聊天详情响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 如果获取成功，打印聊天状态
if ($response->json('code') === 0) {
    $status = $response->json('data.status');
    echo "聊天状态: {$status}\n";
}
