<?php
require_once __DIR__.'/../../vendor/autoload.php';
$config = require __DIR__.'/../config.php';

use Simonetoo\Coze\Coze;


$coze = new Coze([
    'token' => $config['token'],
]);

$response = $coze->bots()->list($config('spaceId'));

var_dump($response->json());
