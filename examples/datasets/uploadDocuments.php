<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "上传文档到知识库...\n";
$datasetId = '7484881587176734755'; // 请替换为实际的知识库ID

// 首先上传一个文件
echo "上传文件...\n";
$testFilePath = __DIR__.'/test_document.txt';
file_put_contents($testFilePath, '这是一个测试文档，用于演示Datasets API的上传功能。'.date('Y-m-d H:i:s'));

try {
    $fileResponse = $client->files()->upload($testFilePath);
    $fileId = $fileResponse->json()['file_id'];
    echo "文件上传成功，文件ID: {$fileId}\n";
    
    // 然后将文件添加到知识库
    $documents = [
        [
            'document_name' => '测试文档-' . date('YmdHis'),
            'file_id' => $fileId
        ]
    ];
    
    $response = $client->datasets()->uploadDocuments($datasetId, $documents);
    echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} finally {
    // 清理测试文件
    if (file_exists($testFilePath)) {
        unlink($testFilePath);
    }
}
