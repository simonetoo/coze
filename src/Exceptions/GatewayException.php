<?php

namespace Simonetoo\Coze\Exceptions;

use Throwable;

class GatewayException extends ApiException
{
    /**
     * 初始化网关错误异常
     *
     * @param  string  $message  异常消息
     * @param  int  $code  异常代码
     * @param  array  $errorData  错误数据
     * @param  Throwable|null  $previous  上一个异常
     */
    public function __construct(
        string $message = "Gateway Error",
        int $code = 502,
        array $errorData = [],
        Throwable|null $previous = null
    ) {
        parent::__construct($message, $code, $errorData, $previous);
    }
}
