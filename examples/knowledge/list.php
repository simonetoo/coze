<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL'
]);

$datasetId = '7484952582571114536';

echo "查看知识库文件列表...\n";

// 基本调用
$response = $client->knowledge()->list($datasetId);

echo "基本列表查询结果：\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// 带分页和筛选条件的调用
$response = $client->knowledge()->list($datasetId, [
    'page' => 1,
    'page_size' => 10,
    'status' => 'processed', // 可选值：processing, processed, failed
]);

echo "\n\n带分页和筛选的查询结果：\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
