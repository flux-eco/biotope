<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

use WeakMap;

enum HttpRequestMessageAttribute: string
{
    case METHOD = "GET";
    case CONTENT_TYPE = "contentType";
    case HEADER = "header";
    case CONTENT = "content";

    case RAW_BODY = "rawBody";

    public function has(WeakMap $object): bool
    {
        return $object->offsetExists($this->value);
    }

    public function get(WeakMap $object): string
    {
        return $object->offsetGet($this->value);
    }

}