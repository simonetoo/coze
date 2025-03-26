<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 修改指定消息
$messageId = '7484881587176734755'; // 使用真实的消息ID，或者先运行create.php获取一个消息ID

$response = $coze->message()->modify($messageId, [
    'content' => 'This is an updated message from SDK',
    'content_type' => 'text',
]);

// 输出响应
echo "修改消息响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

// 输出修改后的消息内容
if ($response->json('code') === 0) {
    $content = $response->json('data.content');
    echo "修改后的消息内容: {$content}\n";
}
