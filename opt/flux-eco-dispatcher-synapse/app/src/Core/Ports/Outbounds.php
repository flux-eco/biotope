<?php

namespace FluxEco\DispatcherSynapse\Core\Ports;

use FluxEco\DispatcherSynapse\Core\Domain\ValueObjects;

final readonly class Outbounds {

    private function __construct(
        public string $dispatcherConfigPath,
        public ValueObjects\Server $fromOrbital,
        public ValueObjects\Server $messageStreamOrbital,
        public Publisher\MessagePublisher $messagePublisher,
    )
    {

    }

    public static function new(
        string $dispatcherConfigPath,
        ValueObjects\Server $fromOrbital,
        ValueObjects\Server $messageStreamOrbital,
        Publisher\MessagePublisher $messagePublisher
    ) {
        return new self(...get_defined_vars());
    }
}