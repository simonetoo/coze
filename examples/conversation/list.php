<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $coze->conversation()->list([
    'bot_id' => '7484523878849822754',
    'page_num' => 1,
    'page_size' => 10,
]);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
