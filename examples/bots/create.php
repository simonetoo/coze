<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */


require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$spaceId = '7484524201249194023';

echo "创建新机器人...\n";

$response = $client->bots()->create(
    '7484524201249194023',
    '测试机器人_'.date('YmdHis'),
    '这是一个通过API创建的测试机器人，创建时间: '.date('Y-m-d H:i:s')
);

print json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
