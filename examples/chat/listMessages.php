<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 会话ID和机器人ID
$conversationId = '7485914486474375231'; // 使用刚刚创建的会话ID
$botId = '7484523878849822754'; // 请替换为实际的机器人ID

// 获取聊天消息列表
$response = $coze->chat()->listMessages([
    'conversation_id' => $conversationId,
    'bot_id' => $botId,
    'page_num' => 1,
    'page_size' => 10,
]);

// 输出响应
echo "获取聊天消息列表响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 如果获取成功，打印消息数量
if ($response->json('code') === 0) {
    $messages = $response->json('data.messages');
    $count = count($messages);
    echo "消息数量: {$count}\n";

    // 打印第一条消息内容（如果存在）
    if ($count > 0) {
        $firstMessage = $messages[0];
        echo "第一条消息:\n";
        echo "角色: {$firstMessage['role']}\n";
        echo "内容: {$firstMessage['content']}\n";
    }
}
