<?php

/**
 * 扣子 Files API 使用示例
 *
 * 本示例展示如何使用扣子 PHP SDK 上传文件和获取文件信息
 */

// 引入自动加载器（假设使用 Composer）
require_once __DIR__.'/../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 替换为您的扣子 Personal Access Token
$token = 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL';

// 初始化扣子客户端
$coze = new Coze($token);

// 创建一个测试文件
$testFilePath = __DIR__.'/test_upload.txt';
file_put_contents($testFilePath, 'This is a test file for Coze Files API.');

try {
    echo "开始上传文件...\n";

    // 方法 1: 使用文件路径上传文件
    $response = $coze->files()->upload($testFilePath);

    // 直接解析响应体，避免使用可能有问题的json()方法
    $responseBody = $response->getBody();
    $decodedResponse = json_decode($responseBody, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON解析错误: '.json_last_error_msg());
    }

    if (! isset($decodedResponse['data'])) {
        echo "警告: 响应中没有data字段\n";
        echo '完整响应: '.$responseBody."\n";
        throw new Exception('响应格式不符合预期');
    }

    $fileData = $decodedResponse['data'];

    echo "文件上传成功！\n";
    echo '文件 ID: '.$fileData['id']."\n";
    echo '文件大小: '.$fileData['bytes']." 字节\n";
    echo '文件名: '.$fileData['file_name']."\n";
    echo '上传时间: '.date('Y-m-d H:i:s', $fileData['created_at'])."\n\n";

    // 获取已上传文件的信息
    echo "获取文件信息...\n";
    $fileInfoResponse = $coze->files()->retrieve($fileData['id']);
    $fileInfoBody = $fileInfoResponse->getBody();
    $decodedFileInfo = json_decode($fileInfoBody, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON解析错误: '.json_last_error_msg());
    }

    if (! isset($decodedFileInfo['data'])) {
        echo "警告: 响应中没有data字段\n";
        echo '完整响应: '.$fileInfoBody."\n";
        throw new Exception('响应格式不符合预期');
    }

    $fileInfo = $decodedFileInfo['data'];

    echo "文件信息获取成功！\n";
    echo '文件 ID: '.$fileInfo['id']."\n";
    echo '文件大小: '.$fileInfo['bytes']." 字节\n";
    echo '文件名: '.$fileInfo['file_name']."\n";
    echo '上传时间: '.date('Y-m-d H:i:s', $fileInfo['created_at'])."\n\n";

    // 方法 2: 使用 SplFileInfo 对象上传文件
    echo "使用 SplFileInfo 上传文件...\n";
    $fileInfoObj = new SplFileInfo($testFilePath);
    $response = $coze->files()->upload($fileInfoObj);
    $responseBody = $response->getBody();
    $decodedResponse = json_decode($responseBody, true);

    if (json_last_error() !== JSON_ERROR_NONE || ! isset($decodedResponse['data'])) {
        echo "警告: 响应解析失败或格式不符合预期\n";
        echo '完整响应: '.$responseBody."\n";
    } else {
        $fileData = $decodedResponse['data'];
        echo "文件上传成功！\n";
        echo '文件 ID: '.$fileData['id']."\n\n";
    }

    // 方法 3: 使用资源上传文件
    echo "使用资源上传文件...\n";
    $resource = fopen($testFilePath, 'r');
    $response = $coze->files()->upload($resource);
    $responseBody = $response->getBody();
    $decodedResponse = json_decode($responseBody, true);

    if (json_last_error() !== JSON_ERROR_NONE || ! isset($decodedResponse['data'])) {
        echo "警告: 响应解析失败或格式不符合预期\n";
        echo '完整响应: '.$responseBody."\n";
    } else {
        $fileData = $decodedResponse['data'];
        echo "文件上传成功！\n";
        echo '文件 ID: '.$fileData['id']."\n";
    }

    // 确保资源仍然有效再关闭
    if (is_resource($resource)) {
        fclose($resource);
    }

} catch (Exception $e) {
    echo '错误: '.$e->getMessage()."\n";

    // 获取更详细的错误信息
    if (method_exists($e, 'getResponse') && $e->getResponse()) {
        echo '响应状态码: '.$e->getResponse()->getStatusCode()."\n";
        echo '响应内容: '.$e->getResponse()->getBody()."\n";
    }

    if (method_exists($e, 'getErrorData')) {
        echo '错误详情: '.json_encode($e->getErrorData(), JSON_PRETTY_PRINT)."\n";
    }

    // 显示堆栈跟踪以便调试
    echo "堆栈跟踪:\n".$e->getTraceAsString()."\n";
} finally {
    // 清理测试文件
    if (file_exists($testFilePath)) {
        unlink($testFilePath);
        echo "\n测试文件已删除\n";
    }
}
