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

// 取消正在进行的聊天
$response = $coze->chat()->cancel($chatId, $conversationId);

// 输出响应
echo "取消聊天响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 如果取消成功，打印token统计信息
if ($response->json('code') === 0) {
    $tokenCount = $response->json('data.token_count');
    $inputCount = $response->json('data.input_count');
    $outputCount = $response->json('data.output_count');

    echo "Token统计:\n";
    echo "总Token数: {$tokenCount}\n";
    echo "输入Token数: {$inputCount}\n";
    echo "输出Token数: {$outputCount}\n";
}
