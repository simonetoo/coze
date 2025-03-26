<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 删除指定消息
$conversationId = '7484524201249194023'; // 使用真实的会话ID
$messageId = '7484881587176734755'; // 使用真实的消息ID，或者先运行create.php获取一个消息ID

$response = $coze->message()->delete($conversationId, $messageId);

// 输出响应
echo "删除消息响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 检查是否删除成功
if ($response->json('code') === 0) {
    echo "消息删除成功！\n";
} else {
    echo '消息删除失败: '.$response->json('msg')."\n";
}
