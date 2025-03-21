<?php

namespace Simonetoo\Coze\Exceptions;

use Throwable;

class PermissionDeniedException extends ApiException
{
    /**
     * 初始化权限拒绝异常
     *
     * @param  string  $message  异常消息
     * @param  int  $code  异常代码
     * @param  array  $errorData  错误数据
     * @param  Throwable|null  $previous  上一个异常
     */
    public function __construct(string $message = 'Permission Denied', int $code = 403, array $errorData = [], ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $errorData, $previous);
    }
}
