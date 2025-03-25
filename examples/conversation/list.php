<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 获取会话列表
$response = $coze->conversation()->list([
    'bot_id' => '7484523878849822754',
    'page_num' => 1,
    'page_size' => 10,
]);

// 输出响应
echo "获取会话列表响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n";

// 获取会话总数
$totalCount = $response->json('data.total_count');
echo "会话总数: {$totalCount}\n";

// 获取会话列表
$conversations = $response->json('data.conversations');
echo "会话列表:\n";
foreach ($conversations as $index => $conversation) {
    echo ($index + 1).". ID: {$conversation['id']}\n";
}
