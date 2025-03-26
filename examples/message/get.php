<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 获取指定消息的详情
$conversationId = '7484524201249194023'; // 使用真实的会话ID
$messageId = '7484881587176734755'; // 使用真实的消息ID，或者先运行create.php获取一个消息ID

$response = $coze->message()->get($conversationId, $messageId);

// 输出响应
echo "获取消息详情响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 输出消息内容
if ($response->json('code') === 0) {
    $content = $response->json('data.content');
    $contentType = $response->json('data.content_type');
    $role = $response->json('data.role');
    $type = $response->json('data.type');

    echo "消息内容: {$content}\n";
    echo "内容类型: {$contentType}\n";
    echo "角色: {$role}\n";
    echo "类型: {$type}\n";
}
