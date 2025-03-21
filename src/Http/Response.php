<?php

namespace Simonetoo\Coze\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class Response
{
    /**
     * 初始化响应对象
     *
     * @param  ResponseInterface  $response  原始响应
     */
    public function __construct(protected ResponseInterface $response) {}

    /**
     * 获取Psr原始响应
     */
    public function getPsrResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * 获取HTTP状态码
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * 获取所有响应头
     */
    public function getHeaders(): array
    {
        return $this->response->getHeaders();
    }

    /**
     * 获取指定响应头
     *
     * @param  string  $name  响应头名称
     * @return array 响应头值数组
     */
    public function getHeader(string $name): array
    {
        return $this->response->getHeader($name);
    }

    /**
     * 获取指定响应头的字符串形式
     *
     * @param  string  $name  响应头名称
     * @return string 响应头值字符串
     */
    public function getHeaderLine(string $name): string
    {
        return $this->response->getHeaderLine($name);
    }

    /**
     * 获取响应体
     */
    public function getBody(): StreamInterface
    {
        return $this->response->getBody();
    }

    /**
     * 将响应对象转换为字符串
     */
    public function __toString(): string
    {
        return $this->getBody();
    }
}
