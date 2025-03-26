<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $client->audio()->speech('7468518753626652709', '这是一个测试文本，用于演示语音合成功能。');

$audio = __DIR__.'/../../temp/audio.mp3';
file_put_contents($audio, $response->getBody());

echo "语音合成成功，文件已保存到: $audio\n";
