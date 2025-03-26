<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$workflowId = '7484881587176734755';

echo "运行工作流（非流式响应）...\n";

$parameters = [
    'user_id' => '12345',
    'user_name' => 'George',
];

$response = $client->workflow()->run(
    $workflowId,
    ['parameters' => $parameters]
);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
