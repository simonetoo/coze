<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 聊天ID和会话ID
$chatId = '7485680322118434850'; // 请替换为实际的聊天ID
$conversationId = '7484881587176734755'; // 请替换为实际的会话ID

// 提交工具执行结果
$response = $coze->chat()->submitToolOutputs([
    'chat_id' => $chatId,
    'conversation_id' => $conversationId,
    'tool_outputs' => [
        [
            'tool_call_id' => 'tool_call_123', // 请替换为实际的工具调用ID
            'output' => json_encode(['result' => '工具执行成功']),
        ],
    ],
]);

// 输出响应
echo "提交工具执行结果响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 如果提交成功，打印聊天状态
if ($response->json('code') === 0) {
    $status = $response->json('data.status');
    echo "聊天状态: {$status}\n";
}
