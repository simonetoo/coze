<?php

namespace Simonetoo\Coze\Http;

use IteratorAggregate;
use Traversable;

class StreamResponse extends Response implements IteratorAggregate
{
    /**
     * 处理流式响应
     */
    public function getIterator(): Traversable
    {
        $body = $this->response->getBody();
        while (!$body->eof()) {
            yield $body->read(1024);
        }
    }
}
