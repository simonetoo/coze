<?php

namespace Simonetoo\Coze\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
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
    protected GuzzleClient $client;

    public function __construct(array $options = [])
    {
        $headers = $options['headers'] ?? [];
        if (! empty($options['token'])) {
            $headers['Authorization'] = "Bearer {$options['token']}";
        }
        $headers['Agw-Js-Conv'] = 'str';
        $this->client = new GuzzleClient([
            ...$options,
            'base_uri' => $options['base_uri'] ?? 'https://api.coze.cn',
            'headers' => $headers,
        ]);
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
    public function delete(string $path, array $options = []): JsonResponse
    {
        $response = $this->request('DELETE', $path, $options);

        return new JsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function patchJson(string $path, array $data = [], array $options = []): JsonResponse
    {
        $options['json'] = $data;
        $response = $this->request('PATCH', $path, $options);

        return new JsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function putJson(string $path, array $data = [], array $options = []): JsonResponse
    {
        $options['json'] = $data;
        $response = $this->request('PUT', $path, $options);

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
    public function request(
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

            $message = $e->getMessage();

            if (! empty($body)) {
                $decodedData = json_decode($body, true);
                if (is_array($decodedData)) {
                    $message = $decodedData['error']['message'] ?? $message;
                }
            }

            throw match ($statusCode) {
                400 => new BadRequestException($message, $statusCode, $response, $e),
                401 => new AuthenticationException($message, $statusCode, $response, $e),
                403 => new PermissionDeniedException($message, $statusCode, $response, $e),
                404 => new NotFoundException($message, $statusCode, $response, $e),
                408 => new TimeoutException($message, $statusCode, $response, $e),
                429 => new RateLimitException($message, $statusCode, $response, $e),
                500 => new InternalServerException($message, $statusCode, $response, $e),
                502, 503, 504 => new GatewayException($message, $statusCode, $response, $e),
                default => new ApiException($message, $statusCode, $response, $e),
            };
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), null, $e);
        }
    }
}
