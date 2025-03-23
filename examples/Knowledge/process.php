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

echo "查看知识库文件上传进度...\n";

// 首先获取文件列表，找到需要查询进度的文件
$listResponse = $client->knowledge()->list($datasetId);
$documents = $listResponse->json('data.documents', []);

if (empty($documents)) {
    echo "没有找到文件，请先上传文件。\n";
    exit;
}

// 获取所有文件ID
$documentIds = array_column($documents, 'document_id');

// 如果文件太多，只取前5个
if (count($documentIds) > 5) {
    $documentIds = array_slice($documentIds, 0, 5);
}

echo "正在查询以下文件的上传进度：\n";
foreach ($documentIds as $id) {
    echo "- {$id}\n";
}

// 查询上传进度
$response = $client->knowledge()->process($datasetId, $documentIds);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
