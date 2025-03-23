<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */


require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "获取机器人列表...\n";
$response = $client->bots()->list('7484524201249194023');

print json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
