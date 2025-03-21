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
        foreach ($this->response->getBody() as $chunk) {
            yield $chunk;
        }
    }
}
