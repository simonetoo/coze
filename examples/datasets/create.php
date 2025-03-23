<?php
/**
 * @author Simon<shihuiqian@xvii.pro>
 */
require_once __DIR__.'/../../vendor/autoload.php';
use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

echo "创建知识库...\n";
$spaceId = '7484524201249194023';
$name = '测试知识库-' . date('YmdHis');
$description = '这是一个通过API创建的测试知识库';

$response = $client->datasets()->create($spaceId, $name, $description);
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
