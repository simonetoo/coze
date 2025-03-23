<?php

namespace Simonetoo\Coze\Exceptions;

use Throwable;

class CozeException extends \Exception
{
    /**
     * 异常
     *
     * @param  string  $message  异常消息
     * @param  int  $code  异常代码
     * @param  Throwable|null  $previous  上一个异常
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
