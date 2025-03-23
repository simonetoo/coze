<?php

namespace Simonetoo\Coze\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class NotFoundException extends ApiException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        string $message = 'Resource Not Found',
        int $code = 404,
        ?ResponseInterface $response = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $response, $previous);
    }
}
