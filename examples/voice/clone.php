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
    // 复刻音色示例
    $voiceName = '测试音色_'.date('YmdHis');

    // 可选参数
    $payload = [
        'description' => '这是一个通过API创建的测试音色',
        // 如果需要上传音频样本，可以添加以下代码
        // 'files' => [
        //     fopen('/path/to/audio/sample.mp3', 'r')
        // ]
    ];

    $response = $client->voice()->clone($voiceName, $payload);

    echo "复刻音色结果:\n";
    echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "\n";
} catch (Exception $e) {
    echo '错误: '.$e->getMessage()."\n";
}
