<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'your-token',
]);

echo "删除知识库...\n";
$datasetId = '7485654914464464915';

// 注意：此操作会永久删除知识库，请谨慎使用
echo "警告：此操作将永久删除知识库，请确认后再执行\n";
echo "按Enter键继续...\n";
fgets(STDIN);

$response = $client->dataset()->delete($datasetId);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
