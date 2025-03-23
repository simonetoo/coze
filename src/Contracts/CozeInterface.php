<?php

namespace Simonetoo\Coze\Contracts;

use Simonetoo\Coze\Http\HttpClient;
use Simonetoo\Coze\Resources\Bots;
use Simonetoo\Coze\Resources\Datasets;
use Simonetoo\Coze\Resources\Files;

interface CozeInterface
{
    /**
     * 获取HTTP客户端
     */
    public function getHttpClient(): HttpClient;

    /**
     * 获取Bots API资源
     */
    public function bots(): Bots;

    /**
     * 获取Files API资源
     */
    public function files(): Files;

    /**
     * 获取Datasets API资源（知识库）
     */
    public function datasets(): Datasets;
}
