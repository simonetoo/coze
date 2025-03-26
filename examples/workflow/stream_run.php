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

echo "运行工作流（流式响应）...\n";

$parameters = [
    'user_id' => '12345',
    'user_name' => 'George',
];

$response = $client->workflow()->streamRun(
    $workflowId,
    ['parameters' => $parameters]
);

// 处理流式响应
foreach ($response->getChunks() as $chunk) {
    echo '收到数据块: '.$chunk.PHP_EOL;
}

echo "流式响应接收完成\n";
