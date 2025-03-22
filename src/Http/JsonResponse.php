<?php

namespace Simonetoo\Coze\Http;

use Simonetoo\Coze\Concerns\Utils;

class JsonResponse extends Response
{
    protected array $decodedJson = [];

    /**
     * 将响应体解析为JSON
     *
     * @template T of mixed
     * @param  string|array|null  $key  要获取的键，使用点符号访问嵌套数组，null返回整个数组
     * @param  T|null  $default  如果键不存在，返回的默认值
     * @return T 解析后的JSON数据
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
}
