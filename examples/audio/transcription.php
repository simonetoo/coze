<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

// 创建一个测试音频文件路径
$testAudioPath = __DIR__.'/test_audio.mp3';

// 如果没有测试音频文件，提示用户
if (! file_exists($testAudioPath)) {
    echo "请在 {$testAudioPath} 放置一个测试音频文件以进行语音识别测试\n";
    echo "或者修改脚本中的音频文件路径指向一个有效的音频文件\n";
    exit(1);
}

try {
    // 语音识别示例
    $response = $client->audio()->transcription($testAudioPath);

    echo "语音识别结果:\n";
    echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "\n";
} catch (Exception $e) {
    echo '错误: '.$e->getMessage()."\n";
}
