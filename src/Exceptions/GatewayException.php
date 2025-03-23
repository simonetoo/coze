<?php

namespace Simonetoo\Coze\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class GatewayException extends ApiException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        string $message = 'Gateway Error',
        int $code = 502,
        ?ResponseInterface $response = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $response, $previous);
    }
}
