<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 请替换为实际的会话ID
$conversationId = '7485680322118434850'; // 示例ID，请替换为实际ID

// 获取会话信息
$response = $coze->conversation()->get($conversationId);

// 输出响应
echo "获取会话响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n";
