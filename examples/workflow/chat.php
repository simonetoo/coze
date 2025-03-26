<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $client->workflow()->chat(
    '7485992458264182834',
    [
        'bot_id' => '7484523878849822754',
        'additional_messages' => [
            [
                'role' => 'user',
                'content' => '你好，请告诉我今天的天气如何？',
            ],
        ],

    ]
);

foreach ($response as $chunk) {
    echo $chunk;
}
