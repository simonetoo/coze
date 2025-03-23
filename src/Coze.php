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
use Simonetoo\Coze\Resources\Bot;
use Simonetoo\Coze\Resources\Dataset;
use Simonetoo\Coze\Resources\File;
use Simonetoo\Coze\Resources\Knowledge;
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
    public function bot(): Bot
    {
        return $this->getResource(Bot::class);
    }

    /**
     * {@inheritdoc}
     */
    public function file(): File
    {
        return $this->getResource(File::class);
    }

    /**
     * {@inheritdoc}
     */
    public function dataset(): Dataset
    {
        return $this->getResource(Dataset::class);
    }

    /**
     * {@inheritdoc}
     */
    public function knowledge(): Knowledge
    {
        return $this->getResource(Knowledge::class);
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
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();

        // 尝试匹配模拟的URL
        foreach ($this->fakeCallbacks as $url => $callback) {
            if (preg_match('#'.preg_quote($url, '#').'#', $path)) {
                $response = $callback($request, $options);
                if ($response instanceof Response) {
                    return $response->getPsrResponse();
                }

                return $response;
            }
        }

        // 如果没有匹配到，抛出异常
        throw new \RuntimeException("No mock response found for path: {$path}");
    }

    protected function matchFakeUrl($request, array $options = []): ?Response
    {
        $path = $request->getUri()->getPath();

        foreach ($this->fakeCallbacks as $url => $callback) {
            if (preg_match('#'.preg_quote($url, '#').'#', $path)) {
                $response = $callback($request, $options);
                if ($response instanceof Response) {
                    return $response;
                }

                return null;
            }
        }

        return null;
    }
}
