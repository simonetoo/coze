<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
]);

$response = $client->workflow()->resume(
    '7441022717041400',
    'Beijing'
);

foreach ($response as $chunk) {
    echo $chunk;
}
