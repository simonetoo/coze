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

echo "修改知识库文件...\n";

// 首先获取文件列表，找到一个可以修改的文件
$listResponse = $client->knowledge()->list($datasetId);
$documents = $listResponse->json('data.documents', []);

if (empty($documents)) {
    echo "没有找到可以修改的文件，请先上传文件。\n";
    exit;
}

// 获取第一个文件的ID
$documentId = $documents[0]['document_id'];
$oldName = $documents[0]['name'];

// 修改文件名称
$newName = '已修改_'.$oldName.'_'.date('YmdHis');

// 设置新的分块策略
$chunkStrategy = [
    'separator' => '\n\n',
    'max_tokens' => 1000,
    'remove_extra_spaces' => true,
    'remove_urls_emails' => false,
    'chunk_type' => 1,
];

echo "正在修改文件 ID: {$documentId}, 原名称: {$oldName}, 新名称: {$newName}\n";

$response = $client->knowledge()->update(
    $datasetId,
    $documentId,
    $newName,
    ['chunk_strategy' => $chunkStrategy]
);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
