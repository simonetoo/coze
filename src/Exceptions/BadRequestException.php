<?php

namespace Simonetoo\Coze\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class BadRequestException extends ApiException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        string $message = 'Bad Request',
        int $code = 400,
        ?ResponseInterface $response = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $response, $previous);
    }
}
