<?php

namespace Simonetoo\Coze;

use GuzzleHttp\HandlerStack;
use Psr\Log\LoggerInterface;

class Config
{
    protected string $token;

    protected string $baseUrl;

    protected int $timeout;

    protected LoggerInterface $logger;

    protected HandlerStack $handler;

    /**
     * 初始化配置
     *
     * @param  array  $options  选项数组
     */
    public function __construct(string $token, array $options = [])
    {
        $this->token = $token;
        $this->baseUrl = $options['baseUrl'] ?? 'https://api.coze.cn';
        $this->timeout = $options['timeout'] ?? 30;
        $this->logger = $options['logger'] ?? new Logger;
        $this->handler = $options['handler'] ?? HandlerStack::create();
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getHandler(): HandlerStack
    {
        return $this->handler;
    }
}
