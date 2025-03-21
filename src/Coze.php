<?php

namespace Simonetoo\Coze;

use Simonetoo\Coze\Contracts\CozeInterface;
use Simonetoo\Coze\Http\HttpClient;
use Simonetoo\Coze\Resources\Bots;
use Simonetoo\Coze\Resources\Files;
use Simonetoo\Coze\Resources\Resource;

class Coze implements CozeInterface
{
    protected HttpClient $httpClient;

    protected Config $config;

    protected array $resources = [];

    /**
     * 初始化Coze客户端
     *
     * @param  string|Config  $token  个人访问令牌(PAT)
     * @param  array  $options  客户端选项
     */
    public function __construct(string|Config $token, array $options = [])
    {
        $this->config = new Config($token, $options);
        $this->httpClient = new HttpClient($this->config);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function bots(): Bots
    {
        return $this->getResource(Bots::class);
    }

    /**
     * {@inheritdoc}
     */
    public function files(): Files
    {
        return $this->getResource(Files::class);
    }

    /**
     * 获取API资源实例（按需实例化）
     *
     * @template T of Resource
     * @param  class-string<T>  $class  API资源类名
     * @return T API资源实例
     */
    protected function getResource(string $class): Resource
    {
        if (! isset($this->resources[$class])) {
            $this->resources[$class] = new $class($this->httpClient);
        }

        return $this->resources[$class];
    }
}
