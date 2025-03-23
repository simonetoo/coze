<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "更新知识库图片描述...\n";
$datasetId = '7484881587176734755'; // 请替换为实际的知识库ID
$documentId = '7484881587176734800'; // 请替换为实际的图片文档ID
$caption = '更新后的图片描述-' . date('YmdHis');

$response = $client->datasets()->updateImageCaption($datasetId, $documentId, $caption);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
