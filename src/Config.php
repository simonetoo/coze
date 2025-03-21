<?php

namespace Simonetoo\Coze;

use Psr\Log\LoggerInterface;

class Config
{
    /** @var string */
    protected string $token;

    /** @var string */
    protected string $baseUrl;

    /** @var int */
    protected int $timeout;

    protected LoggerInterface $logger;

    /**
     * 初始化配置
     *
     * @param  string  $token
     * @param  array  $options  选项数组
     */
    public function __construct(string $token, array $options = [])
    {
        $this->token = $token;
        $this->baseUrl = $options['baseUrl'] ?? 'https://api.coze.cn';
        $this->timeout = $options['timeout'] ?? 30;
        $this->logger = $options['logger'] ?? new Logger();
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
}
