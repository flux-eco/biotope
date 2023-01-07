<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Ports;

use FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

final readonly class Outbounds {

    private function __construct(
        public string $dispatcherConfigPath,
        public ValueObjects\Server $messageStreamServer,
        public Publisher\MessagePublisher $messagePublisher,

    )
    {

    }

    public static function new(
        string $dispatcherConfigPath,
        ValueObjects\Server $messageStreamServer,
        Publisher\MessagePublisher $messagePublisher
    ) {
        return new self(...get_defined_vars());
    }
}