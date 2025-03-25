<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'your-token'
]);

$datasetId = '7484952582571114536';

echo "查看知识库文件列表...\n";

// 基本调用
$response = $client->knowledge()->list($datasetId);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
