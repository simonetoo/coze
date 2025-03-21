<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Contracts\ApiResourceInterface;
use Simonetoo\Coze\Contracts\HttpClientInterface;

abstract class Resource implements ApiResourceInterface
{
    protected HttpClientInterface $client;

    /**
     * 初始化API资源
     *
     * @param  HttpClientInterface  $httpClient  HTTP客户端实例
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }
}
