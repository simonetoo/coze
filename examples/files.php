<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端，使用真实token
$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL'
]);

// 创建一个测试文件
$testFilePath = __DIR__ . '/test_file.txt';
file_put_contents($testFilePath, '这是一个测试文件，用于演示Files API的上传功能。' . date('Y-m-d H:i:s'));

echo "已创建测试文件: " . $testFilePath . "\n";
echo "\n-----------------------------------\n\n";

/**
 * 示例1: 上传文件
 */
try {
    echo "上传文件...\n";
    echo "文件路径: " . $testFilePath . "\n";
    
    $response = $client->files()->upload($testFilePath);
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') === 0) {
        $fileInfo = $response->json('data') ?? [];
        echo "上传成功！\n";
        echo "文件ID: " . ($fileInfo['file_id'] ?? $response->json('file_id') ?? '未返回ID') . "\n";
        echo "文件名: " . ($fileInfo['filename'] ?? '未返回文件名') . "\n";
        echo "文件大小: " . ($fileInfo['size'] ?? '未返回大小') . " 字节\n";
        echo "内容类型: " . ($fileInfo['content_type'] ?? '未返回内容类型') . "\n";
        echo "上传时间: " . ($fileInfo['created_at'] ?? '未返回上传时间') . "\n";
        
        // 保存文件ID用于后续示例
        $fileId = $fileInfo['file_id'] ?? $response->json('file_id');
        if ($fileId) {
            echo "已保存文件ID用于后续示例: " . $fileId . "\n";
        } else {
            echo "未能获取文件ID\n";
            $fileId = 'default_file_id';
        }
    } else {
        echo "上传文件失败: " . $response->json('message') . "\n";
    }
} catch (Exception $e) {
    echo "上传文件时发生错误: " . $e->getMessage() . "\n";
}

echo "\n-----------------------------------\n\n";

/**
 * 示例2: 获取文件信息
 */
try {
    echo "获取文件信息...\n";
    
    // 使用上传的文件ID，如果没有则使用默认值
    $retrieveFileId = isset($fileId) ? $fileId : 'your_file_id';
    echo "文件ID: " . $retrieveFileId . "\n";
    
    $response = $client->files()->retrieve($retrieveFileId);
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') === 0) {
        $fileInfo = $response->json('data') ?? [];
        echo "获取成功！\n";
        echo "文件ID: " . ($fileInfo['file_id'] ?? '未返回ID') . "\n";
        echo "文件名: " . ($fileInfo['filename'] ?? '未返回文件名') . "\n";
        echo "文件大小: " . ($fileInfo['size'] ?? '未返回大小') . " 字节\n";
        echo "内容类型: " . ($fileInfo['content_type'] ?? '未返回内容类型') . "\n";
        echo "创建时间: " . ($fileInfo['created_at'] ?? '未返回创建时间') . "\n";
        echo "状态: " . ($fileInfo['status'] ?? '未返回状态') . "\n";
        
        if (isset($fileInfo['url']) && $fileInfo['url']) {
            echo "文件URL: " . $fileInfo['url'] . "\n";
        } else {
            echo "文件URL: 不可用\n";
        }
    } else {
        echo "获取文件信息失败: " . $response->json('message') . "\n";
    }
} catch (Exception $e) {
    echo "获取文件信息时发生错误: " . $e->getMessage() . "\n";
}

echo "\n-----------------------------------\n\n";

/**
 * 示例3: 上传不存在的文件（异常处理示例）
 */
try {
    echo "尝试上传不存在的文件...\n";
    
    $nonExistentFilePath = __DIR__ . '/non_existent_file.txt';
    echo "文件路径: " . $nonExistentFilePath . "\n";
    
    $response = $client->files()->upload($nonExistentFilePath);
    // 这行代码不会执行，因为上面会抛出异常
    echo "响应状态码: " . $response->json('code') . "\n";
} catch (InvalidArgumentException $e) {
    echo "预期的异常: " . $e->getMessage() . "\n";
    echo "异常类型: " . get_class($e) . "\n";
} catch (Exception $e) {
    echo "其他异常: " . $e->getMessage() . "\n";
    echo "异常类型: " . get_class($e) . "\n";
}

echo "\n-----------------------------------\n\n";

/**
 * 示例4: 获取不存在的文件信息（错误处理示例）
 */
try {
    echo "尝试获取不存在的文件信息...\n";
    
    $nonExistentFileId = 'non_existent_file_id_' . time();
    echo "文件ID: " . $nonExistentFileId . "\n";
    
    $response = $client->files()->retrieve($nonExistentFileId);
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') !== 0) {
        echo "预期的错误: 文件不存在\n";
    }
} catch (Exception $e) {
    echo "获取不存在文件信息时发生错误: " . $e->getMessage() . "\n";
    echo "异常类型: " . get_class($e) . "\n";
}

// 清理测试文件
if (file_exists($testFilePath)) {
    unlink($testFilePath);
    echo "已删除测试文件: " . $testFilePath . "\n";
}

echo "\n完成所有Files API示例\n";
