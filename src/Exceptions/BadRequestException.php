<?php

namespace Simonetoo\Coze\Exceptions;

use Throwable;

class BadRequestException extends ApiException
{
    /**
     * 初始化错误请求异常
     *
     * @param  string  $message  异常消息
     * @param  int  $code  异常代码
     * @param  array  $errorData  错误数据
     * @param  Throwable|null  $previous  上一个异常
     */
    public function __construct(
        string $message = 'Bad Request',
        int $code = 400,
        array $errorData = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $errorData, $previous);
    }
}
