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

echo "创建知识库文件...\n";

// 示例：上传本地文件到知识库
// 注意：实际使用时需要替换为真实的文件内容
$documentBases = [
    [
        'name' => '测试文档_'.date('YmdHis').'.txt',
        'source_info' => [
            // 这里使用了一个简单的Base64编码的文本内容
            'file_base64' => base64_encode('这是一个测试文档内容，创建时间: '.date('Y-m-d H:i:s')),
            'file_type' => 'txt',
        ],
    ],
];

// 设置分块策略
$chunkStrategy = [
    'separator' => '\n\n',
    'max_tokens' => 800,
    'remove_extra_spaces' => false,
    'remove_urls_emails' => false,
    'chunk_type' => 1,
];

$response = $client->knowledge()->create(
    $datasetId,
    $documentBases,
    ['chunk_strategy' => $chunkStrategy]
);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
