<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Simonetoo\Coze\Coze;

$client = new Coze([
    'token' => 'your-token',
]);


$response = $client->knowledge()->update(
    '7484952582571114536',
    [
        'document_name' => '测试',
    ]
);

echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
