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

echo "更新知识库图片描述...\n";

// 首先获取图片列表
$imagesResponse = $client->knowledge()->images($datasetId);
$images = $imagesResponse->json('data.images', []);

if (empty($images)) {
    echo "没有找到图片，请先上传图片到知识库。\n";
    exit;
}

// 获取第一张图片的ID
$imageId = $images[0]['image_id'];
$oldCaption = $images[0]['caption'] ?? '无描述';

// 设置新的图片描述
$newCaption = '更新的图片描述_'.date('YmdHis');

echo "正在更新图片 ID: {$imageId}\n";
echo "原描述: {$oldCaption}\n";
echo "新描述: {$newCaption}\n";

// 更新图片描述
$response = $client->knowledge()->imageCaption($datasetId, $imageId, $newCaption);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
