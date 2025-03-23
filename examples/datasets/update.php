<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "更新知识库信息...\n";
$datasetId = '7484881587176734755'; // 请替换为实际的知识库ID

$payload = [
    'name' => '更新后的知识库名称-' . date('YmdHis'),
    'description' => '这是通过API更新的知识库描述'
];

$response = $client->datasets()->update($datasetId, $payload);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
