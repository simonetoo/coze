<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo '确认删除? (y/n): ';
$confirmation = trim(fgets(STDIN));

if (strtolower($confirmation) !== 'y') {
    echo "操作已取消\n";
    exit;
}

// 执行删除操作
$response = $client->knowledge()->delete('7485659086604910644');

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
