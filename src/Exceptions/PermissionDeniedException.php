<?php

namespace Simonetoo\Coze\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class PermissionDeniedException extends ApiException
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        string $message = 'Permission Denied',
        int $code = 403,
        ?ResponseInterface $response = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $response, $previous);
    }
}
