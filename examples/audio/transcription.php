<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);
$audio = __DIR__.'/../../temp/audio.mp3';
if (! file_exists($audio)) {
    $response = $client->audio()->speech('7468518753626652709', '这是一个测试文本，用于演示语音合成功能。');
    file_put_contents($audio, $response->getBody());
}

// 语音识别示例
$response = $client->audio()->transcription($audio);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
