<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $coze->message()->create(
    '7485929034791075891',
    'Hello, this is a test message from SDK',
    'text',
    'user',
    'question'
);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
