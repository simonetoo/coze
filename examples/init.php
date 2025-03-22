<?php
require_once __DIR__.'/../vendor/autoload.php';


use Simonetoo\Coze\Concerns\Utils;
use Simonetoo\Coze\Coze;

$config = [
    'token' => 'pat_e44qxZ0p9VCw0ImW7FLgyE6qWTd7IMGCiKnUAdaqfJKQ3jRkdXeYgEnZSnlGxigL',
    'spaceId' => '7484524201249194023',
    'botId' => '7484523878849822754',
];

function coze_create(): Coze
{
    global $config;
    return new Coze([
        'token' => $config['token'],
    ]);
}

/**
 * @template T of mixed
 * @param  string  $key
 * @param  T|null  $default
 * @return T
 */
function coze_config(string $key, mixed $default = null): mixed
{
    global $config;
    return Utils::dataGet($config, $key, $default);
}

function coze_dump_response($response): void
{
    var_dump($response);
}
