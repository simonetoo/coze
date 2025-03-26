<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 取消正在进行的聊天
$response = $coze->chat()->cancel('7484881587176734755', '7485680322118434850');

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
