<?php

namespace Simonetoo\Coze\Contracts;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\Response;
use Simonetoo\Coze\Http\StreamResponse;

interface HttpClientInterface
{
    /**
     * 发送GET请求
     *
     * @param  string  $path  API路径
     * @param  array  $query  查询参数
     * @param  array  $options  请求选项
     * @return Response 响应对象
     * @throws ApiException 请求异常
     */
    public function get(string $path, array $query = [], array $options = []): Response;

    /**
     * 发送POST请求
     *
     * @param  string  $path  API路径
     * @param  array  $options  请求选项
     * @return Response 响应对象
     * @throws ApiException 请求异常
     */
    public function post(string $path, array $options = []): Response;

    /**
     * 发送JSON POST请求
     *
     * @param  string  $path  API路径
     * @param  array  $data  请求数据
     * @param  array  $options  请求选项
     * @return Response 响应对象
     * @throws ApiException 请求异常
     */
    public function postJson(string $path, array $data = [], array $options = []): Response;

    /**
     * 发送流式请求
     *
     * @param  string  $method  请求方法
     * @param  string  $path  API路径
     * @param  array  $options  请求选项
     * @return StreamResponse 流式响应对象
     * @throws ApiException 请求异常
     */
    public function stream(string $method, string $path, array $options = []): StreamResponse;
}
