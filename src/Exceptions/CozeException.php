<?php

namespace Simonetoo\Coze\Exceptions;

use Throwable;

class CozeException extends \Exception
{
    /** @var array|null */
    protected ?array $errorData;

    /**
     * 初始化异常
     *
     * @param  string  $message  异常消息
     * @param  int  $code  异常代码
     * @param  array|null  $errorData  错误数据
     * @param  Throwable|null  $previous  上一个异常
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        array|null $errorData = null,
        Throwable|null $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorData = $errorData;
    }

    /**
     * 获取错误数据
     *
     * @return array|null
     */
    public function getErrorData(): ?array
    {
        return $this->errorData;
    }
}
