# Coze PHP SDK

一个用于无缝集成Coze AI能力到PHP应用程序的SDK。

## 目录

- [简介](#简介)
- [安装](#安装)
  - [系统要求](#系统要求)
  - [通过Composer安装](#通过composer安装)
  - [手动安装](#手动安装)
- [配置](#配置)
  - [获取API密钥](#获取api密钥)
  - [初始化SDK](#初始化sdk)
  - [环境变量配置](#环境变量配置)
- [快速开始](#快速开始)
  - [基本用法](#基本用法)
  - [错误处理](#错误处理)
- [使用示例](#使用示例)
  - [机器人(Bot)操作](#机器人bot操作)
  - [文件(File)操作](#文件file操作)
  - [音频(Audio)处理](#音频audio处理)
  - [语音(Voice)操作](#语音voice操作)
  - [工作空间(Workspace)操作](#工作空间workspace操作)
  - [知识库(Knowledge)操作](#知识库knowledge操作)
- [API 参考](#api-参考)
  - [核心客户端](#核心客户端)
  - [机器人 (Bot)](#机器人-bot)
  - [文件 (File)](#文件-file)
  - [音频 (Audio)](#音频-audio)
  - [语音 (Voice)](#语音-voice)
  - [数据集 (Dataset)](#数据集-dataset)
  - [知识库 (Knowledge)](#知识库-knowledge)
  - [工作空间 (Workspace)](#工作空间-workspace)
  - [会话 (Conversation)](#会话-conversation)
  - [聊天 (Chat)](#聊天-chat)
  - [消息 (Message)](#消息-message)
  - [工作流 (Workflow)](#工作流-workflow)
  - [响应处理](#响应处理)
  - [错误处理](#错误处理-1)
- [测试](#测试)
- [贡献指南](#贡献指南)
- [许可证](#许可证)

## 简介

Coze PHP SDK 是一个功能强大的工具包，为开发者提供了简单而灵活的方式来集成Coze AI平台的各种功能到PHP应用中。通过这个SDK，您可以轻松访问Coze的机器人、聊天、知识库、语音合成与识别等多种AI能力，而无需处理底层API的复杂性。

Coze是一个全面的AI平台，提供了丰富的功能来构建智能应用。本SDK封装了Coze的REST API，使PHP开发者能够以面向对象的方式与Coze平台交互。无论您是想构建智能客服系统、知识管理平台，还是需要语音识别和合成功能的应用，Coze PHP SDK都能满足您的需求。

### 主要特性

- **简单易用**：提供直观的API，使复杂的AI功能调用变得简单
- **完整覆盖**：支持Coze平台的所有主要功能，包括机器人、聊天、知识库、工作流、音频处理等
- **类型安全**：利用PHP的类型提示功能，提供更好的开发体验
- **灵活配置**：支持多种配置选项，适应不同的应用场景
- **完善的错误处理**：提供清晰的错误信息和异常处理机制
- **测试友好**：内置模拟功能，便于单元测试

### 支持的功能

SDK支持Coze平台的所有核心功能，包括但不限于：

- 机器人管理与交互
- 文件上传与管理
- 数据集与知识库操作
- 工作空间管理
- 会话与聊天功能
- 消息处理
- 工作流操作
- 语音合成与识别
- 音色管理

无论您是构建简单的聊天机器人，还是开发复杂的AI驱动应用，Coze PHP SDK都能为您提供所需的工具和接口。

## 安装

### 系统要求

- PHP 8.0 或更高版本
- [Composer](https://getcomposer.org/)
- 以下PHP扩展：
  - JSON
  - cURL
  - fileinfo

### 通过Composer安装

Coze PHP SDK 可以通过 [Composer](https://getcomposer.org/) 轻松安装。只需在项目目录中运行以下命令：

```bash
composer require simonetoo/coze
```

### 手动安装

如果您不使用Composer，也可以手动安装：

1. 从 [GitHub仓库](https://github.com/simonetoo/coze) 下载最新版本
2. 将文件解压到您的项目目录
3. 设置自己的自动加载机制或使用SDK提供的自动加载器

```php
require_once '/path/to/coze/vendor/autoload.php';
```

## 配置

### 获取API密钥

在使用SDK之前，您需要从Coze平台获取API密钥：

1. 登录 [Coze开发者平台](https://www.coze.com)
2. 导航至"开发者设置"或"API密钥"部分
3. 创建新的API密钥或使用现有密钥

### 初始化SDK

在您的应用中初始化Coze SDK：

```php
<?php

require_once 'vendor/autoload.php';

use Simonetoo\Coze\Coze;

// 使用API密钥初始化客户端
$client = new Coze([
    'token' => 'your_api_key_here',
    // 可选配置
    'timeout' => 30, // 请求超时时间（秒）
    'base_uri' => 'https://api.coze.com', // 自定义API基础URL（如有需要）
]);
```

### 环境变量配置

为了安全起见，建议使用环境变量存储API密钥。您可以使用 `.env` 文件结合 `vlucas/phpdotenv` 包（SDK开发依赖中已包含）：

```php
<?php

require_once 'vendor/autoload.php';

// 加载.env文件
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Simonetoo\Coze\Coze;

// 从环境变量获取API密钥
$client = new Coze([
    'token' => $_ENV['COZE_API_KEY'],
]);
```

您的 `.env` 文件应该包含：

```
COZE_API_KEY=your_api_key_here
```

请确保将 `.env` 文件添加到 `.gitignore` 中，避免将API密钥提交到版本控制系统。

## 快速开始

以下是一些基本示例，展示如何使用Coze PHP SDK进行常见操作。

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

## API 参考

本节提供了Coze PHP SDK中所有可用资源和方法的详细参考。

### 核心客户端

`Simonetoo\Coze\Coze` 类是SDK的主要入口点，用于初始化客户端并访问各种资源。

```php
// 初始化客户端
$client = new Coze([
    'token' => 'your_api_key_here',
    'timeout' => 30, // 可选，请求超时时间（秒）
    'base_uri' => 'https://api.coze.com', // 可选，自定义API基础URL
]);
```

#### 可用方法

| 方法 | 返回类型 | 描述 |
|------|----------|------|
| `getHttpClient()` | `HttpClient` | 获取HTTP客户端实例 |
| `bot()` | `Bot` | 获取机器人资源 |
| `file()` | `File` | 获取文件资源 |
| `dataset()` | `Dataset` | 获取数据集资源 |
| `knowledge()` | `Knowledge` | 获取知识库资源 |
| `workspace()` | `Workspace` | 获取工作空间资源 |
| `conversation()` | `Conversation` | 获取会话资源 |
| `chat()` | `Chat` | 获取聊天资源 |
| `message()` | `Message` | 获取消息资源 |
| `workflow()` | `Workflow` | 获取工作流资源 |
| `audio()` | `Audio` | 获取音频资源 |
| `voice()` | `Voice` | 获取语音资源 |

#### 测试工具方法

| 方法 | 返回类型 | 描述 |
|------|----------|------|
| `fake(array $options = [])` | `Coze` | 创建一个模拟客户端，用于测试 |
| `mock(string\|array $urls, callable\|array\|string\|Response\|null $callback = null)` | `self` | 模拟特定URL的响应 |
| `response(string\|array $body = '', int $status = 200, array $headers = [])` | `JsonResponse` | 创建一个JSON响应对象 |
| `stream(array $chunks, int $status = 200, array $headers = [])` | `StreamResponse` | 创建一个流式响应对象 |

### 机器人 (Bot)

`Bot` 资源用于管理和操作Coze平台上的机器人。

```php
$botResource = $client->bot();
```

#### 可用方法

| 方法 | 参数 | 返回类型 | 描述 |
|------|------|----------|------|
| `list()` | 无 | `JsonResponse` | 获取机器人列表 |
| `retrieve(string $botId)` | 机器人ID | `JsonResponse` | 获取特定机器人的详细信息 |

### 文件 (File)

`File` 资源用于上传和管理文件。

```php
$fileResource = $client->file();
```

#### 可用方法

| 方法 | 参数 | 返回类型 | 描述 |
|------|------|----------|------|
| `upload(string $path)` | 文件路径 | `JsonResponse` | 上传文件 |
| `retrieve(string $fileId)` | 文件ID | `JsonResponse` | 获取文件信息 |

### 音频 (Audio)

`Audio` 资源用于语音合成和识别功能。

```php
$audioResource = $client->audio();
```

#### 可用方法

| 方法 | 参数 | 返回类型 | 描述 |
|------|------|----------|------|
| `speech(string $voiceId, string $input, array $payload = [])` | 音色ID, 文本内容, 可选参数 | `ResponseInterface` | 将文本转换为语音 |
| `transcription(string $path)` | 音频文件路径 | `JsonResponse` | 将语音转换为文本 |

##### speech方法参数详解

- `$voiceId`: 要使用的音色ID
- `$input`: 需要转换为语音的文本内容
- `$payload`: 可选参数，可包含以下键：
  - `speed`: 语速，默认为1.0
  - `format`: 输出格式，如'mp3'、'wav'等

##### transcription方法参数详解

- `$path`: 需要识别的音频文件路径，支持多种格式如mp3、wav等

### 语音 (Voice)

`Voice` 资源用于管理和操作语音音色。

```php
$voiceResource = $client->voice();
```

#### 可用方法

| 方法 | 参数 | 返回类型 | 描述 |
|------|------|----------|------|
| `list()` | 无 | `JsonResponse` | 获取可用音色列表 |
| `clone(string $name, string $path, array $payload = [])` | 音色名称, 音频文件路径, 可选参数 | `JsonResponse` | 创建自定义音色 |

##### clone方法参数详解

- `$name`: 新音色的名称
- `$path`: 用于创建音色的音频样本文件路径
- `$payload`: 可选参数，可包含以下键：
  - `preview_text`: 用于预览的文本
  - `description`: 音色描述
  - `audio_format`: 音频格式，如果未指定，将从文件扩展名推断

### 数据集 (Dataset)

`Dataset` 资源用于管理知识库数据集。

```php
$datasetResource = $client->dataset();
```

### 知识库 (Knowledge)

`Knowledge` 资源用于管理知识库。

```php
$knowledgeResource = $client->knowledge();
```

### 工作空间 (Workspace)

`Workspace` 资源用于管理工作空间。

```php
$workspaceResource = $client->workspace();
```

### 会话 (Conversation)

`Conversation` 资源用于管理会话。

```php
$conversationResource = $client->conversation();
```

### 聊天 (Chat)

`Chat` 资源用于管理聊天功能。

```php
$chatResource = $client->chat();
```

### 消息 (Message)

`Message` 资源用于管理消息。

```php
$messageResource = $client->message();
```

### 工作流 (Workflow)

`Workflow` 资源用于管理工作流。

```php
$workflowResource = $client->workflow();
```

### 响应处理

SDK提供了几种响应类型来处理不同的API返回：

#### JsonResponse

大多数API调用返回`JsonResponse`对象，它提供了以下方法：

```php
$response = $client->bot()->list();

// 获取JSON数据
$data = $response->json();

// 获取原始响应体
$body = $response->getBody();

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

## 测试

SDK提供了测试工具，使您能够轻松地为使用SDK的代码编写单元测试。

### 模拟客户端

您可以使用`fake()`方法创建一个模拟客户端：

```php
use Simonetoo\Coze\Coze;

// 创建模拟客户端
$client = Coze::fake();

// 模拟特定URL的响应
$client->mock('v1/bots', [
    'bots' => [
        ['id' => '123', 'name' => '测试机器人'],
    ]
]);

// 使用模拟客户端
$response = $client->bot()->list();
$bots = $response->json()['bots'];

// 断言结果
assert($bots[0]['id'] === '123');
```

### 运行测试

您可以使用以下命令运行SDK的单元测试：

```bash
composer test
```

## 贡献指南

我们欢迎并感谢所有形式的贡献。如果您想为Coze PHP SDK做出贡献，请遵循以下步骤：

1. Fork仓库
2. 创建您的特性分支 (`git checkout -b feature/amazing-feature`)
3. 提交您的更改 (`git commit -m 'Add some amazing feature'`)
4. 推送到分支 (`git push origin feature/amazing-feature`)
5. 打开Pull Request

在提交代码前，请确保：

1. 您的代码符合项目的编码标准（使用`composer pint`检查和修复代码风格）
2. 您已经为新功能编写了测试
3. 所有测试都能通过（使用`composer test`运行测试）
4. 您已经更新了相关文档

## 许可证

Coze PHP SDK 使用 MIT 许可证。详情请参阅 [LICENSE](LICENSE) 文件。
