<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Ports\IncomingMessages;
use FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

final readonly class DispatchNextMessage
{
    private function __construct(
        public ValueObjects\From $from,
        public ValueObjects\To $to,
        public object $message
    ) {

    }

    public static function new(
        ValueObjects\From $from,
        ValueObjects\To $to,
        object $message
    ) : self {
        return new self(
            ...get_defined_vars()
        );
    }
}