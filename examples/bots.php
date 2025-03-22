<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 初始化Coze客户端，使用真实token
$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL'
]);

// 设置空间ID（使用用户提供的真实空间ID）
$spaceId = '7407755085679837193';

// 设置机器人ID（使用用户提供的真实机器人ID）
$botId = '7407755502459338761';

/**
 * 示例1: 获取机器人列表
 */
try {
    echo "获取机器人列表...\n";
    $response = $client->bots()->list($spaceId);
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') === 0) {
        $bots = $response->json('data.bots') ?? [];
        $total = $response->json('data.total') ?? 0;
        
        echo "总机器人数量: " . $total . "\n";
        echo "机器人列表:\n";
        
        if (!empty($bots)) {
            foreach ($bots as $index => $bot) {
                echo ($index + 1) . ". ID: " . $bot['bot_id'] . ", 名称: " . $bot['name'] . "\n";
                
                // 如果找到了机器人，更新botId变量以便后续示例使用
                if ($index === 0) {
                    $botId = $bot['bot_id'];
                    echo "已自动设置botId为: " . $botId . " 用于后续示例\n";
                }
            }
        } else {
            echo "没有找到机器人\n";
        }
    } else {
        echo "获取机器人列表失败: " . $response->json('message') . "\n";
    }
} catch (Exception $e) {
    echo "获取机器人列表时发生错误: " . $e->getMessage() . "\n";
}

echo "\n-----------------------------------\n\n";

/**
 * 示例2: 获取机器人详情
 */
try {
    echo "获取机器人详情...\n";
    echo "使用机器人ID: " . $botId . "\n";
    
    $response = $client->bots()->get($botId);
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') === 0) {
        $botInfo = $response->json('data');
        echo "机器人ID: " . $botInfo['bot_id'] . "\n";
        echo "机器人名称: " . $botInfo['name'] . "\n";
        echo "机器人描述: " . $botInfo['description'] . "\n";
        echo "创建时间: " . $botInfo['created_at'] . "\n";
        echo "更新时间: " . $botInfo['updated_at'] . "\n";
    } else {
        echo "获取机器人详情失败: " . $response->json('message') . "\n";
    }
} catch (Exception $e) {
    echo "获取机器人详情时发生错误: " . $e->getMessage() . "\n";
}

echo "\n-----------------------------------\n\n";

/**
 * 示例3: 创建机器人
 */
try {
    echo "创建新机器人...\n";
    
    $botName = "测试机器人_" . date('YmdHis');
    $botDescription = "这是一个通过API创建的测试机器人，创建时间: " . date('Y-m-d H:i:s');
    
    // 额外的payload数据
    $additionalPayload = [
        'settings' => [
            'language' => 'zh-CN',
            'visibility' => 'private',
        ],
    ];
    
    echo "机器人名称: " . $botName . "\n";
    echo "机器人描述: " . $botDescription . "\n";
    
    $response = $client->bots()->create(
        $spaceId,
        $botName,
        $botDescription,
        $additionalPayload
    );
    
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') === 0) {
        $newBot = $response->json('data') ?? [];
        echo "创建成功！\n";
        echo "新机器人ID: " . ($newBot['bot_id'] ?? $response->json('bot_id') ?? '未返回ID') . "\n";
        echo "新机器人名称: " . ($newBot['name'] ?? '未返回名称') . "\n";
        
        // 保存新创建的机器人ID，用于后续更新示例
        $newBotId = $newBot['bot_id'] ?? $response->json('bot_id');
        if ($newBotId) {
            echo "已保存新机器人ID用于后续更新示例: " . $newBotId . "\n";
        } else {
            echo "未能获取新机器人ID，将使用之前的ID\n";
            $newBotId = $botId;
        }
    } else {
        echo "创建机器人失败: " . $response->json('message') . "\n";
    }
} catch (Exception $e) {
    echo "创建机器人时发生错误: " . $e->getMessage() . "\n";
}

echo "\n-----------------------------------\n\n";

/**
 * 示例4: 更新机器人
 */
try {
    echo "更新机器人...\n";
    
    // 使用前面创建的机器人ID，如果没有则使用默认的
    $updateBotId = isset($newBotId) ? $newBotId : $botId;
    $updatedName = "更新后的机器人_" . date('YmdHis');
    
    // 额外的payload数据
    $updatePayload = [
        'description' => "这是一个更新后的描述，更新时间: " . date('Y-m-d H:i:s'),
        'settings' => [
            'visibility' => 'public',
        ],
    ];
    
    echo "更新机器人ID: " . $updateBotId . "\n";
    echo "更新后的名称: " . $updatedName . "\n";
    
    $response = $client->bots()->update(
        $updateBotId,
        $updatedName,
        $updatePayload
    );
    
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') === 0) {
        $updatedBot = $response->json('data') ?? [];
        echo "更新成功！\n";
        echo "机器人ID: " . ($updatedBot['bot_id'] ?? $response->json('bot_id') ?? '未返回ID') . "\n";
        echo "更新后的名称: " . ($updatedBot['name'] ?? '未返回名称') . "\n";
        echo "更新后的描述: " . ($updatedBot['description'] ?? '未返回描述') . "\n";
        echo "更新时间: " . ($updatedBot['updated_at'] ?? '未返回更新时间') . "\n";
    } else {
        echo "更新机器人失败: " . $response->json('message') . "\n";
    }
} catch (Exception $e) {
    echo "更新机器人时发生错误: " . $e->getMessage() . "\n";
}

echo "\n-----------------------------------\n\n";

/**
 * 示例5: 分页获取机器人列表
 */
try {
    echo "分页获取机器人列表...\n";
    
    $page = 1;
    $limit = 5;
    
    echo "页码: " . $page . ", 每页数量: " . $limit . "\n";
    
    $response = $client->bots()->list($spaceId, $page, $limit);
    echo "响应状态码: " . $response->json('code') . "\n";
    echo "响应消息: " . $response->json('message') . "\n";
    
    if ($response->json('code') === 0) {
        $bots = $response->json('data.bots') ?? [];
        $total = $response->json('data.total') ?? 0;
        
        echo "总机器人数量: " . $total . "\n";
        echo "当前页机器人数量: " . count($bots) . "\n";
        echo "机器人列表:\n";
        
        if (!empty($bots)) {
            foreach ($bots as $index => $bot) {
                echo ($index + 1) . ". ID: " . $bot['bot_id'] . ", 名称: " . $bot['name'] . "\n";
            }
        } else {
            echo "当前页没有机器人\n";
        }
        
        // 计算总页数
        $totalPages = $total > 0 ? ceil($total / $limit) : 0;
        echo "总页数: " . $totalPages . "\n";
    } else {
        echo "分页获取机器人列表失败: " . $response->json('message') . "\n";
    }
} catch (Exception $e) {
    echo "分页获取机器人列表时发生错误: " . $e->getMessage() . "\n";
}

echo "\n完成所有Bots API示例\n";
