<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 获取聊天消息列表
$response = $coze->chat()->listMessages('7485915767599300618', '7485915767599317002');

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
