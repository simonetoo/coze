<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$executeId = '7441022717041400'; // 这是一个示例ID，实际使用时需要替换为真实的执行ID
$answer = 'Beijing'; // 用户对问题的回答

echo "恢复被中断的工作流执行...\n";

$response = $client->workflow()->resume(
    $executeId,
    $answer
);

// 处理流式响应
foreach ($response->getChunks() as $chunk) {
    echo '收到数据块: '.$chunk.PHP_EOL;
}

echo "流式响应接收完成\n";
