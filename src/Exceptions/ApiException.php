<?php

namespace Simonetoo\Coze\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApiException extends CozeException
{
    protected ?ResponseInterface $response = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?ResponseInterface $response = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }
}
