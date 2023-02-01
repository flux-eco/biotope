<?php

namespace FluxEco\PhpSynapse\Core\Domain\Messages;

use WeakMap;

final readonly class ResponseMessage
{
    private function __construct(
        public MessageHeader $header,
        public WeakMap $content
    )
    {

    }

    public static function new(
        MessageHeader $header,
        WeakMap $content
    ): self
    {
        return new self(...get_defined_vars());
    }
}