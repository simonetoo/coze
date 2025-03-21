<?php

namespace Simonetoo\Coze\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response as Psr7Response;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
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
     
    /**
     * 伪造的响应
     *
     * @var callable
     */
    protected static array $fakeResponses = [];
    
    /**
     * 启用响应伪造
     *
     * @param callable|null $callback 伪造响应回调函数
     * @return void
     */
    public static function fake(callable|array|null $callback = null): void
    {
        if(is_null($callback)){
            $callback = function (){
                return static::response();
            };
        }
        if(is_callable($callback)){
            $callback = [
                '*/*' => $callback
            ];
        }

        static::$fakeResponseCallback = $callback;
    }
    
    /**
     * 创建伪造响应
     *
     * @param mixed $body 响应内容
     * @param int $status 状态码
     * @param array $headers 响应头
     * @return ResponseInterface
     */
    public static function response($body = null, int $status = 200, array $headers = []): ResponseInterface
    {
        if (is_array($body)) {
            $body = json_encode($body);

            $headers['Content-Type'] = 'application/json';
        }

        return new Psr7Response($status, $headers, $body);
    }

    /**
     * 创建流式伪造响应
     *
     * @param string|array|StreamInterface|null $body 响应内容
     * @param int $status 状态码
     * @param array $headers 响应头
     * @return ResponseInterface
     */
    public static function streamResponse(string|array|StreamInterface|null $body = null, int $status = 200, array $headers = []): ResponseInterface
    {
        // 如果是数组，创建一个迭代器，一条一条数据响应，来模拟流式响应
        if (is_array($body)) {
            $stream = fopen('php://temp', 'r+');
            
            // 将每个数组项作为一个JSON行写入流
            foreach ($body as $item) {
                $line = is_string($item) ? $item : json_encode($item);
                fwrite($stream, $line . "\n");
            }
            
            // 重置流指针到开始位置
            rewind($stream);
            
            // 设置Content-Type为流式JSON
            $headers['Content-Type'] = 'application/x-ndjson';
            
            return new Psr7Response($status, $headers, $stream);
        }
        
        // 如果已经是StreamInterface，直接使用
        if ($body instanceof StreamInterface) {
            return new Psr7Response($status, $headers, $body);
        }
        
        // 如果是字符串，创建一个流
        if (is_string($body)) {
            $stream = fopen('php://temp', 'r+');
            fwrite($stream, $body);
            rewind($stream);
            
            return new Psr7Response($status, $headers, $stream);
        }
        
        // 默认返回空响应
        return new Psr7Response($status, $headers, null);
    }

    /**
     * 初始化HTTP客户端
     *
     * @param  Config  $config  配置对象
     */
    public function __construct(Config|string $config, array $options = [])
    {
        if(is_string($config)){
            $config = new Config($config, $options);
        }
        $this->config = $config;
        $handler = $config->getHandler();
        $this->client = new GuzzleClient([
            'handler' => $handler,
            'base_uri' => $config->getBaseUrl(),
            'timeout' => $config->getTimeout(),
            'headers' => [
                'Authorization' => 'Bearer '.$config->getToken(),
                'User-Agent' => 'github.com/simonetoo/coze',
            ],
        ]);
        
        // 添加中间件来处理伪造响应
        $handler->push(function ($handler) {
            return function ($request, $options) use ($handler) {
                // 判断是否处于伪造模式
                if (!empty(static::$fakeResponseCallback)) {

                    // 获取请求方法和路径
                    $method = $request->getMethod();
                    $path = $request->getUri()->getPath();
                     // 补全代码：根据method和path匹配到对象的callback

                    
                    // 调用伪造响应回调函数
                    $response = $callback($request, $options);
                    
                    // 如果回调返回了响应，则使用该响应
                    if ($response instanceof ResponseInterface) {
                        return \GuzzleHttp\Promise\Create::promiseFor($response);
                    }
                }
                
                // 如果没有伪造响应或不处于伪造模式，则继续正常请求
                return $handler($request, $options);
            };
        });
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
            $this->handleRequestException($e);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage(), $e->getCode(), [], $e);
        }
    }

    /**
     * 处理请求异常
     *
     * @param  RequestException  $e  请求异常
     *
     * @throws ApiException 转换后的API异常
     */
    protected function handleRequestException(RequestException $e): never
    {
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
    }
}
