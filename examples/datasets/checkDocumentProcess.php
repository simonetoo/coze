<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "检查文档处理进度...\n";
$datasetId = '7484881587176734755'; // 请替换为实际的知识库ID
$documentIds = ['7484881587176734800']; // 请替换为实际的文档ID数组

$response = $client->datasets()->checkDocumentProcess($datasetId, $documentIds);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
