# Coze PHP SDK

Coze PHP SDK为开发者提供了简单而灵活的方式来集成Coze AI平台的各种功能到PHP应用中。通过这个SDK，您可以轻松访问Coze的机器人、聊天、知识库、语音合成与识别等多种AI能力，而无需处理底层API的复杂性。

### 主要特性

- **简单易用**：提供直观的API，使复杂的AI功能调用变得简单
- **完整覆盖**：支持Coze平台的所有主要功能，包括机器人、聊天、知识库、工作流、音频处理等
- **类型安全**：利用PHP的类型提示功能，提供更好的开发体验
- **灵活配置**：支持多种配置选项，适应不同的应用场景
- **完善的错误处理**：提供清晰的错误信息和异常处理机制
- **测试友好**：内置模拟功能，便于单元测试

## 安装

### 系统要求

- PHP:^8.0
- ext-json:*
- ext-curl:*

### 通过Composer安装
```bash
composer require simonetoo/coze
```

## 配置

### 获取API密钥

在使用SDK之前，您需要从Coze平台获取API密钥：https://www.coze.cn/open/docs/developer_guides/pat

## 快速开始

### 基本用法

#### 初始化客户端

所有与Coze API的交互都始于创建一个Coze客户端实例：

```php
<?php

require_once 'vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用API密钥初始化客户端
$client = new Coze([
    'token' => 'your_api_key_here',
]);
```

#### 错误处理

SDK使用异常来处理错误。建议使用try-catch块来捕获和处理可能的异常：

```php
<?php

use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Exceptions\ApiException;

try {
    $client = new Coze([
        'token' => 'your_api_key_here',
    ]);
    
    // 执行API调用
    $response = $client->bot()->list();
    
    // 处理响应
    $bots = $response->json();
    
} catch (ApiException $e) {
    // 处理API错误
    echo "API错误: " . $e->getMessage();
    echo "HTTP状态码: " . $e->getCode();
    
    // 获取更多错误详情（如果有）
    if ($e->hasResponse()) {
        $errorDetails = $e->getResponse()->json();
        echo "错误详情: " . json_encode($errorDetails);
    }
} catch (\Exception $e) {
    // 处理其他错误
    echo "错误: " . $e->getMessage();
}
```

## 使用示例

### 机器人(Bot)操作

获取机器人列表：

```php
$response = $client->bot()->list();
$bots = $response->json();
```

获取特定机器人信息：

```php
$botId = '7484523878849822754';
$response = $client->bot()->retrieve($botId);
$botInfo = $response->json();
```

### 文件(File)操作

上传文件：

```php
$filePath = '/path/to/your/file.jpg';
$response = $client->file()->upload($filePath);
$fileInfo = $response->json();
$fileId = $fileInfo['file_id'];
```

获取文件信息：

```php
$fileId = '7484881587176734755';
$response = $client->file()->retrieve($fileId);
$fileInfo = $response->json();
```

### 音频(Audio)处理

语音合成（文本转语音）：

```php
// 语音合成示例
$voiceId = '7468518753626652709'; // 音色ID
$text = '这是一个测试文本，用于演示语音合成功能。';

$response = $client->audio()->speech($voiceId, $text);

// 保存生成的音频文件
$audioFile = '/path/to/save/audio.mp3';
file_put_contents($audioFile, $response->getBody());

echo "语音合成成功，文件已保存到: $audioFile\n";
```

语音识别（语音转文本）：

```php
// 语音识别示例
$audioPath = '/path/to/your/audio.mp3';
$response = $client->audio()->transcription($audioPath);

// 输出识别结果
$result = $response->json();
echo "识别文本: " . $result['text'] . "\n";
echo "音频时长: " . $result['duration'] . " 秒\n";
echo "识别语言: " . $result['language'] . "\n";
```

### 语音(Voice)操作

获取可用音色列表：

```php
// 获取音色列表示例
$response = $client->voice()->list();
$voices = $response->json()['voices'];

// 输出所有可用音色
foreach ($voices as $voice) {
    echo "ID: " . $voice['id'] . "\n";
    echo "名称: " . $voice['name'] . "\n";
    echo "描述: " . $voice['description'] . "\n";
    echo "语言: " . $voice['language'] . "\n";
    echo "------------------------\n";
}
```

复刻自定义音色：

```php
// 复刻音色示例
$audioPath = '/path/to/sample/audio.mp3';
$voiceName = '自定义音色名称';

$response = $client->voice()->clone($voiceName, $audioPath, [
    'preview_text' => '这是一个用于预览的文本示例。',
]);

// 输出结果
$result = $response->json();
echo "音色ID: " . $result['voice_id'] . "\n";
echo "音色名称: " . $result['name'] . "\n";
echo "状态: " . $result['status'] . "\n";
```

### 工作空间(Workspace)操作

获取工作空间列表：

```php
$response = $client->workspace()->list();
$workspaces = $response->json();
```

### 知识库(Knowledge)操作

获取知识库列表：

```php
$workspaceId = '7484524201249194023';
$response = $client->knowledge()->list($workspaceId);
$knowledgeBases = $response->json();
```

更多示例可以在SDK的`examples`目录中找到。

### 响应处理

SDK提供了几种响应类型来处理不同的API返回：

#### JsonResponse

大多数API调用返回`JsonResponse`对象，它提供了以下方法：

```php
$response = $client->bot()->list();

// 获取JSON数据
$json = $response->json();

// 根据path获取数据
$item = $response->json('data.item', 'default');

// 获取code
$code = $response->code();

// 获取数据
$data = $response->data();
// 根据path获取数据
$item = $response->data('item', 'default')

// 获取HTTP状态码
$statusCode = $response->getStatusCode();

// 获取响应头
$headers = $response->getHeaders();
```

#### 流式响应

某些API（如大型文件下载）可能返回流式响应，可以这样处理：

```php
$response = $client->audio()->speech('voice_id', 'Hello world');

// 保存到文件
file_put_contents('output.mp3', $response->getBody());
```

### 错误处理

SDK使用异常来处理错误。所有API相关的异常都继承自`ApiException`：

```php
try {
    $response = $client->bot()->retrieve('invalid_id');
} catch (\Simonetoo\Coze\Exceptions\ApiException $e) {
    echo "API错误: " . $e->getMessage();
    echo "HTTP状态码: " . $e->getCode();
    
    if ($e->hasResponse()) {
        $errorDetails = $e->getResponse()->json();
        echo "错误详情: " . json_encode($errorDetails);
    }
}
```

## 贡献指南
[查看贡献指南](CONTRIBUTING.md)

## 许可证
[MIT LICENSE](LICENSE)
