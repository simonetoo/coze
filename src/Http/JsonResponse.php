<?php

namespace Simonetoo\Coze\Http;

use Closure;

class JsonResponse extends Response
{
    /** @var array */
    protected array $decodedJson = [];

    /**
     * 将响应体解析为JSON
     *
     * @return mixed 解析后的JSON数据
     */
    public function json(string|array|null $key, mixed $default = null): mixed
    {
        if (empty($this->decodedJson)) {
            if (empty($this->body)) {
                $this->decodedJson = [];
            } else {
                $this->decodedJson = json_decode($this->body, true);
            }
        }
        return $this->dataGet($this->decodedJson, $key, $default);
    }

    private function dataGet(array $target, string|array|null $key, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $target;
        }

        // 如果 key 是字符串，将其转换为数组
        $keys = is_array($key) ? $key : explode('.', $key);

        foreach ($keys as $segment) {
            if (is_array($target)) {
                if (! array_key_exists($segment, $target)) {
                    return $this->dataValue($default);
                }

                $target = $target[$segment];
            } elseif (is_object($target)) {
                if (! isset($target->{$segment})) {
                    return $this->dataValue($default);
                }

                $target = $target->{$segment};
            } else {
                return $this->dataValue($default);
            }
        }

        return $target;
    }

    private function dataValue($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
