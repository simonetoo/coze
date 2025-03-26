<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$workflowId = '7484881587176734755';

echo "执行聊天工作流...\n";

// 构建消息列表
$messages = [
    [
        'role' => 'user',
        'content' => '你好，请告诉我今天的天气如何？',
    ],
];

// 可选参数
$payload = [
    'bot_id' => '7484523878849822754', // 可选，关联的机器人ID
];

$response = $client->workflow()->chat(
    $workflowId,
    $messages,
    $payload
);

// 处理流式响应
foreach ($response->getChunks() as $chunk) {
    echo '收到数据块: '.$chunk.PHP_EOL;
}

echo "流式响应接收完成\n";
