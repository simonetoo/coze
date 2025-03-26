<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$coze = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $coze->conversation()->get('7485680322118434850');

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
