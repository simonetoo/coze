<?php
namespace Simonetoo\Coze\Contracts;

use Simonetoo\Coze\Resources\Bots;
use Simonetoo\Coze\Resources\Files;
use Simonetoo\Coze\Config;
use Simonetoo\Coze\Http\HttpClient;

interface CozeInterface
{
    /**
     * 获取配置
     *
     * @return Config
     */
    public function getConfig(): Config;

    /**
     * 获取HTTP客户端
     *
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient;

    /**
     * 获取Bots API资源
     *
     * @return Bots
     */
    public function bots(): Bots;

    /**
     * 获取Files API资源
     *
     * @return Files
     */
    public function files(): Files;
}
