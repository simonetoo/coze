<?php

namespace Simonetoo\Coze\Http;

use Closure;
use Simonetoo\Coze\Concerns\Utils;

class JsonResponse extends Response
{
    protected array $decodedJson = [];

    protected ?Closure $transformer;

    /**
     * 获取Json数据
     *
     * @param  string|array|null  $key  要获取的键，使用点符号访问嵌套数组，null返回整个数组
     * @param  mixed  $default  如果键不存在，返回的默认值
     * @return mixed 解析后的JSON数据
     */
    public function json(string|array|null $key = null, mixed $default = null): mixed
    {
        if (empty($this->decodedJson)) {
            $body = (string) $this->getBody();
            if (empty($body)) {
                $this->decodedJson = [];
            } elseif (isset($this->transformer)) {
                $this->decodedJson = call_user_func($this->transformer, $body);
            } else {
                $this->decodedJson = json_decode($body, true, 512, JSON_BIGINT_AS_STRING);
            }
        }

        return Utils::dataGet($this->decodedJson, $key, $default);
    }

    public function data(string|array|null $key = null, mixed $default = null): mixed
    {
        $data = $this->json('data', []);
        if (is_array($data)) {
            return Utils::dataGet($data, $key, $default);
        }

        return is_null($key) ? $data : $default;
    }

    public function code(): int
    {
        return $this->data('code');
    }

    public function message(): string
    {
        return $this->json('msg', '');
    }

    public function isSuccess(): bool
    {
        return $this->code() === 0;
    }

    public function isFailure(): bool
    {
        return ! $this->isSuccess();
    }

    public function transform(Closure $transformer): JsonResponse
    {
        $this->transformer = $transformer;

        return $this;
    }
}
