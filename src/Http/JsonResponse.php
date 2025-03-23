<?php

namespace Simonetoo\Coze\Http;

use Simonetoo\Coze\Concerns\Utils;

class JsonResponse extends Response
{
    protected array $decodedJson = [];

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
            } else {
                $this->decodedJson = json_decode($body, true);
            }
        }

        return Utils::dataGet($this->decodedJson, $key, $default);
    }

    public function data(string|array|null $key = null, mixed $default = null): mixed
    {
        $data = $this->json('data', []);

        return Utils::dataGet($data, $key, $default);
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
}
