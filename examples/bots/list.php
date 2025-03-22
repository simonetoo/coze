<?php
require_once __DIR__.'/../init.php';

$coze = coze_create();

$response = $coze->bots()->list('7484524201249194023');

coze_dump_response($response);

