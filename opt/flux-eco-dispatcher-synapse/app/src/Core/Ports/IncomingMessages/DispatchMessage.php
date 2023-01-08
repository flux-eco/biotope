<?php

namespace FluxEco\DispatcherSynapse\Core\Ports\IncomingMessages;
use FluxEco\DispatcherSynapse\Core\Domain\ValueObjects;

final readonly class DispatchMessage
{
    private function __construct(
        public string $addressPath,
        public object $message
    ) {

    }

    public static function new(
        string $addressPath,
        object $message
    ) : self {
        return new self(
            ...get_defined_vars()
        );
    }
}