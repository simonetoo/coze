<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */


require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$botId = '7484523878849822754';

echo "更新机器人...\n";
$response = $client->bots()->update(
    $botId,
    [
        'name' =>   '更新后的机器人_'.date('YmdHis'),
        'description' => '这是一个更新后的描述，更新时间: '.date('Y-m-d H:i:s'),
    ]
);

print json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
