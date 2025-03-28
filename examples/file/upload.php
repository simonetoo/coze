<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$testFilePath = __DIR__.'/test_file.txt';
file_put_contents($testFilePath, '这是一个测试文件，用于演示Files API的上传功能。'.date('Y-m-d H:i:s'));

try {
    $response = $client->file()->upload($testFilePath);
    echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} finally {
    unlink($testFilePath);
}
