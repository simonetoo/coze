<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "获取知识库列表...\n";
$spaceId = '7484524201249194023';

$response = $client->dataset()->list($spaceId);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
