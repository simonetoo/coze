<?php

namespace Simonetoo\Coze\Concerns;

use Closure;

class Utils
{
    public static function dataGet(array $target, string|array|null $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $target;
        }
        // 如果 key 是字符串，将其转换为数组
        $keys = is_array($key) ? $key : explode('.', $key);
        foreach ($keys as $segment) {
            if (is_array($target)) {
                if (! array_key_exists($segment, $target)) {
                    return static::dataValue($default);
                }
                $target = $target[$segment];
            } elseif (is_object($target)) {
                if (! isset($target->{$segment})) {
                    return static::dataValue($default);
                }
                $target = $target->{$segment};
            } else {
                return static::dataValue($default);
            }
        }

        return $target;
    }

    public static function dataValue($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
