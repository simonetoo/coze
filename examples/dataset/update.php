<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'your-token',
]);

echo "更新知识库信息...\n";
$datasetId = '7484952400601497626';

$payload = [
    'description' => '这是通过API更新的知识库描述',
];

$response = $client->dataset()->update($datasetId, '更新后的知识库名称-'.date('YmdHis'), $payload);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
