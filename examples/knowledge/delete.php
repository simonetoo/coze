<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$datasetId = '7484881587176734755';

echo "删除知识库文件...\n";

// 首先获取文件列表，找到可以删除的文件
$listResponse = $client->knowledge()->list($datasetId);
$documents = $listResponse->json('data.documents', []);

if (empty($documents)) {
    echo "没有找到可以删除的文件，请先上传文件。\n";
    exit;
}

// 获取最后一个文件的ID（避免删除重要文件）
$lastDocument = end($documents);
$documentId = $lastDocument['document_id'];
$documentName = $lastDocument['name'];

echo "准备删除文件 ID: {$documentId}, 名称: {$documentName}\n";
echo '确认删除? (y/n): ';
$confirmation = trim(fgets(STDIN));

if (strtolower($confirmation) !== 'y') {
    echo "操作已取消\n";
    exit;
}

// 执行删除操作
$response = $client->knowledge()->delete($datasetId, [$documentId]);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
