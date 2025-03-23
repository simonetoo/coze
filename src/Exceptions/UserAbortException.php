<?php

namespace Simonetoo\Coze\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class UserAbortException extends ApiException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        string $message = 'User Aborted Request',
        int $code = 499,
        ?ResponseInterface $response = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $response, $previous);
    }
}
