<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $coze->chat()->submitToolOutputs('7484881587176734755', '7485680322118434850', [
    [
        'tool_call_id' => 'tool_call_123', // 请替换为实际的工具调用ID
        'output' => json_encode(['result' => '工具执行成功']),
    ],
]);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
