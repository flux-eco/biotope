<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;
use WeakMap;

final readonly class HttpRequest {
    private function __construct(
        ContentType $contentType,
        WeakMap $header,
        WeakMap $content,
    ) {

    }

    public static function new(
        ContentType $contentType,
        WeakMap $header,
        WeakMap $content,
    ) {

    }
}