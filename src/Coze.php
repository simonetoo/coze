<?php

namespace Simonetoo\Coze;

use GuzzleHttp\HandlerStack;
use Simonetoo\Coze\Contracts\CozeInterface;
use Simonetoo\Coze\Http\HttpClient;
use Simonetoo\Coze\Resources\Bots;
use Simonetoo\Coze\Resources\Files;
use Simonetoo\Coze\Resources\Resource;

class Coze implements CozeInterface
{
    protected HttpClient $httpClient;

    protected array $resources = [];

    protected HandlerStack $stack;

    /**
     * 初始化Coze客户端
     *
     * @param  array  $options  客户端选项
     */
    public function __construct(array $options = [])
    {
        $this->stack = $options['handler'] ?? HandlerStack::create();
        $headers = $options['headers'] ?? [];
        if (! empty($options['token'])) {
            $headers['Authorization'] = "Bearer {$options['token']}";
        }
        $this->httpClient = new HttpClient([
            ...$options,
            'handler' => $this->stack,
            'base_uri' => $options['base_uri'] ?? 'https://api.cozei.cn',
            'headers' => $headers,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    public function middleware(callable $callback): self
    {
        $this->stack->push($callback);
        return $this;
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
     *
     * @param  class-string<T>  $class  API资源类名
     * @return T
     */
    protected function getResource(string $class)
    {
        if (! isset($this->resources[$class])) {
            $this->resources[$class] = new $class($this->httpClient);
        }

        return $this->resources[$class];
    }


}
