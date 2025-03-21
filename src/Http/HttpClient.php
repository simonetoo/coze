<?php

namespace Simonetoo\Coze\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Simonetoo\Coze\Config;
use Simonetoo\Coze\Contracts\HttpClientInterface;
use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Exceptions\AuthenticationException;
use Simonetoo\Coze\Exceptions\BadRequestException;
use Simonetoo\Coze\Exceptions\GatewayException;
use Simonetoo\Coze\Exceptions\InternalServerException;
use Simonetoo\Coze\Exceptions\NotFoundException;
use Simonetoo\Coze\Exceptions\PermissionDeniedException;
use Simonetoo\Coze\Exceptions\RateLimitException;
use Simonetoo\Coze\Exceptions\TimeoutException;

class HttpClient implements HttpClientInterface
{
    /**
     * 配置对象
     */
    protected Config $config;

    /**
     * Guzzle HTTP 客户端
     */
    protected GuzzleClient $client;


    public function __construct(array $options = [])
    {
        $this->client = new GuzzleClient($options);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $path, array $query = [], array $options = []): JsonResponse
    {
        $options['query'] = $query;
        $response = $this->request('GET', $path, $options);

        return new JsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function postJson(string $path, array $data = [], array $options = []): JsonResponse
    {
        $options['json'] = $data;
        $response = $this->request('POST', $path, $options);

        return new JsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $path, array $options = []): JsonResponse
    {
        $response = $this->request('POST', $path, $options);

        return new JsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function stream(string $method, string $path, array $options = []): StreamResponse
    {
        $options['stream'] = true;
        $response = $this->request($method, $path, $options);

        return new StreamResponse($response);
    }

    /**
     * 发送请求
     *
     * @param  string  $method  请求方法
     * @param  string  $path  API路径
     * @param  array  $options  请求选项
     * @return ResponseInterface 响应对象
     *
     * @throws ApiException 请求异常
     */
    protected function request(
        string $method,
        string $path,
        array $options = []
    ): ResponseInterface {
        try {
            return $this->client->request($method, $path, $options);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : 0;
            $body = (string) $response?->getBody();

            $errorData = null;
            $message = $e->getMessage();

            if (! empty($body)) {
                $errorData = json_decode($body, true);
                $message = $errorData['error']['message'] ?? $message;
            }

            throw match ($statusCode) {
                400 => new BadRequestException($message, $statusCode, $errorData, $e),
                401 => new AuthenticationException($message, $statusCode, $errorData, $e),
                403 => new PermissionDeniedException($message, $statusCode, $errorData, $e),
                404 => new NotFoundException($message, $statusCode, $errorData, $e),
                408 => new TimeoutException($message, $statusCode, $errorData, $e),
                429 => new RateLimitException($message, $statusCode, $errorData, $e),
                500 => new InternalServerException($message, $statusCode, $errorData, $e),
                502, 503, 504 => new GatewayException($message, $statusCode, $errorData, $e),
                default => new ApiException($message, $statusCode, $errorData, $e),
            };
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), [], $e);
        }
    }
}
