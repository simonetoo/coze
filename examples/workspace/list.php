<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用您的个人访问令牌初始化Coze客户端
$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 获取工作空间列表
$response = $coze->workspace()->list([
    'page_num' => 1,
    'page_size' => 10,
]);

// 输出响应
echo "获取工作空间列表响应:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n";

// 获取工作空间总数
$totalCount = $response->json('data.total_count');
echo "工作空间总数: {$totalCount}\n";

// 获取工作空间列表
$workspaces = $response->json('data.workspaces');
echo "工作空间列表:\n";
foreach ($workspaces as $index => $workspace) {
    echo ($index + 1).". ID: {$workspace['id']}, 名称: {$workspace['name']}\n";
}
