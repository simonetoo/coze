<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "更新知识库文档信息...\n";
$datasetId = '7484881587176734755'; // 请替换为实际的知识库ID
$documentId = '7484881587176734800'; // 请替换为实际的文档ID
$documentName = '更新后的文档名称-' . date('YmdHis');

$response = $client->datasets()->updateDocument($datasetId, $documentId, $documentName);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
