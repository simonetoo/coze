<?php

/**
 * @author Simon<shihuiqian@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$datasetId = '7484881587176734755';

echo "查看知识库图片列表...\n";

// 基本调用
$response = $client->knowledge()->images($datasetId);

echo "基本图片列表查询结果：\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// 带分页和筛选条件的调用
$response = $client->knowledge()->images($datasetId, [
    'page' => 1,
    'page_size' => 10,
    'caption' => '测试', // 可选，按图片描述筛选
]);

echo "\n\n带分页和筛选的图片查询结果：\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
