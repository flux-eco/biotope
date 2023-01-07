<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Ports\IncomingMessages;
use FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

final readonly class DispatchMessage
{
    private function __construct(
        public ValueObjects\From $from,
        public string $addressPath,
        public object $message
    ) {

    }

    public static function new(
        ValueObjects\From $from,
        string $addressPath,
        object $message
    ) : self {
        return new self(
            ...get_defined_vars()
        );
    }
}