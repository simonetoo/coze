<?php

namespace Simonetoo\Coze;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\BufferStream;
use GuzzleHttp\Psr7\Response as PsrResponse;
use Psr\Http\Message\ResponseInterface;
use Simonetoo\Coze\Contracts\CozeInterface;
use Simonetoo\Coze\Http\HttpClient;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Http\Response;
use Simonetoo\Coze\Http\StreamResponse;
use Simonetoo\Coze\Resources\Bots;
use Simonetoo\Coze\Resources\Files;
use Simonetoo\Coze\Resources\Resource;

class Coze implements CozeInterface
{
    protected HttpClient $httpClient;

    protected array $resources = [];

    protected array $fakeCallbacks = [];

    /**
     * 初始化Coze客户端
     *
     * @param  array  $options  客户端选项
     */
    public function __construct(array $options = [])
    {
        $this->httpClient = new HttpClient($options);
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

    public static function fake(array $options = []): Coze
    {
        $handler = new MockHandler;
        $coze = new self([
            ...$options,
            'handler' => HandlerStack::create($handler),
        ]);
        $handler->append(function ($request, $options) use ($coze) {
            return $coze->handleFakeRequest($request, $options);
        });

        return $coze;
    }

    public static function response(string|array $body = '', int $status = 200, array $headers = []): JsonResponse
    {
        if (is_array($body)) {
            $body = json_encode($body, JSON_UNESCAPED_UNICODE);
        }
        $response = new PsrResponse($status, $headers, $body);

        return new JsonResponse($response);
    }

    public static function stream(array $chunks, int $status = 200, array $headers = []): StreamResponse
    {
        $stream = new BufferStream;
        $response = new PsrResponse($status, $headers, $stream);

        return new StreamResponse($response);
    }

    public function mock(
        string|array $urls,
        callable|array|string|Response|null $callback = null
    ): self {

        if (is_string($urls)) {
            $urls = [$urls => $callback];
        }

        foreach ($urls as $url => $callback) {
            if (is_array($callback)) {
                $callback = json_encode($callback, JSON_UNESCAPED_UNICODE);
            }
            if (is_string($callback)) {
                $callback = static::response($callback);
            }

            $this->fakeCallbacks[$url] = function ($request, $options) use ($callback) {
                if (is_callable($callback)) {
                    return $callback($request, $options);
                }

                return $callback;
            };
        }

        return $this;
    }

    public function handleFakeRequest($request, $options): ResponseInterface
    {
        return static::response('123')->getPsrResponse();
    }

    protected function matchFakeUrl($request, array $options = []): ?Response
    {
        var_dump($request->getMethod(), $request->getUrl(), $options);

        return null;
    }
}
