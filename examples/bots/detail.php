<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */


require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "获取机器人详情...\n";
$response = $client->bots()->get('7484523878849822754');


print json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
