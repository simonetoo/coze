<?php

require __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $coze->chat()->chat(
    '7484523878849822754',
    'test_user_123',
    [
        'auto_save_history' => true,
        'stream' => false,
        'messages' => [
            [
                'role' => 'user',
                'content' => '你好，请介绍一下自己',
            ],
        ],
    ]
);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
