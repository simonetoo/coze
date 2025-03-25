<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'your-token',
]);

$datasetId = '7484881587176734755';
$documentId = '7485659086605746000';

// 查询上传进度
$response = $client->knowledge()->process($datasetId, $documentId);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
