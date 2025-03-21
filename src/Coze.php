<?php

namespace Simonetoo\Coze;

use Simonetoo\Coze\Resources\Bots;
use Simonetoo\Coze\Resources\Resource;
use Simonetoo\Coze\Contracts\CozeInterface;
use Simonetoo\Coze\Http\HttpClient;

class Coze implements CozeInterface
{
    /** @var HttpClient */
    protected HttpClient $httpClient;

    /** @var Config */
    protected Config $config;

    /** @var array */
    protected array $resources = [];

    /**
     * 初始化Coze客户端
     *
     * @param  string  $token  个人访问令牌(PAT)
     * @param  array  $options  客户端选项
     */
    public function __construct(string $token, array $options = [])
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
     * 获取API资源实例（按需实例化）
     *
     * @param  string  $class  API资源类名
     * @return mixed API资源实例
     */
    protected function getResource(string $class): Resource
    {
        if (! isset($this->resources[$class])) {
            $this->resources[$class] = new $class($this->httpClient);
        }

        return $this->resources[$class];
    }
}
