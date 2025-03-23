<?php

namespace Simonetoo\Coze\Contracts;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Http\StreamResponse;

interface HttpClientInterface
{
    /**
     * 发送GET请求
     *
     * @param  string  $path  API路径
     * @param  array  $query  查询参数
     * @param  array  $options  请求选项
     *
     * @throws ApiException
     */
    public function get(string $path, array $query = [], array $options = []): JsonResponse;

    /**
     * 发送POST请求
     *
     * @param  string  $path  API路径
     * @param  array  $options  请求选项
     *
     * @throws ApiException
     */
    public function post(string $path, array $options = []): JsonResponse;

    /**
     * 发送JSON POST请求
     *
     * @param  string  $path  API路径
     * @param  array  $data  请求数据
     * @param  array  $options  请求选项
     *
     * @throws ApiException
     */
    public function postJson(string $path, array $data = [], array $options = []): JsonResponse;

    /**
     * 发送DELETE请求
     *
     * @param  string  $path  API路径
     * @param  array  $options  请求选项
     *
     * @throws ApiException
     */
    public function delete(string $path, array $options = []): JsonResponse;

    /**
     * 发送JSON PATCH请求
     *
     * @param  string  $path  API路径
     * @param  array  $data  请求数据
     * @param  array  $options  请求选项
     *
     * @throws ApiException
     */
    public function patchJson(string $path, array $data = [], array $options = []): JsonResponse;

    /**
     * 发送JSON PUT请求
     *
     * @param  string  $path  API路径
     * @param  array  $data  请求数据
     * @param  array  $options  请求选项
     *
     * @throws ApiException
     */
    public function putJson(string $path, array $data = [], array $options = []): JsonResponse;

    /**
     * 发送流式请求
     *
     * @param  string  $method  请求方法
     * @param  string  $path  API路径
     * @param  array  $options  请求选项
     *
     * @throws ApiException
     */
    public function stream(string $method, string $path, array $options = []): StreamResponse;
}
