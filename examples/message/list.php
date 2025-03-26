<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 获取消息列表
$conversationId = '7485929034791075891'; // 使用刚创建的有效会话ID

$response = $coze->message()->list($conversationId, [
    'page_num' => 1,
    'page_size' => 10,
]);

// 输出响应
echo "获取消息列表响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 输出消息数量
$totalCount = $response->json('data.total_count');
echo "消息总数: {$totalCount}\n";

// 如果有消息，输出第一条消息的ID
if ($totalCount > 0 && !empty($response->json('data.messages'))) {
    $firstMessageId = $response->json('data.messages.0.id');
    echo "第一条消息ID: {$firstMessageId}\n";
}
