<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

try {
    // 语音合成示例
    $voiceId = 'alloy'; // 使用默认音色
    $text = '这是一个测试文本，用于演示语音合成功能。';

    $response = $client->audio()->speech($voiceId, $text);

    // 保存合成的音频文件
    $audioFile = __DIR__.'/speech_output.mp3';
    file_put_contents($audioFile, $response->getBody());

    echo "语音合成成功，文件已保存到: $audioFile\n";
} catch (Exception $e) {
    echo '错误: '.$e->getMessage()."\n";
}
