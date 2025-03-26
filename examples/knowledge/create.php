<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$documentBases = [
    [
        'name' => '测试文档_'.date('YmdHis').'.txt',
        'source_info' => [
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
    '7484952582571114536',
    [
        'document_bases' => $documentBases,
        'chunk_strategy' => $chunkStrategy,
    ]
);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
