<?php

namespace Simonetoo\Coze\Http;

use Traversable;
use IteratorAggregate;

class StreamResponse extends Response implements IteratorAggregate
{

    /**
     * 处理流式响应
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        foreach ($this->response->getBody() as $chunk) {
            yield $chunk;
        }
    }
}
