<?php

namespace FluxEco\DispatcherSynapse\Adapters\Config;

use FluxEco\DispatcherSynapse\Core\Domain\ValueObjects;

final readonly class Config
{
    private function __construct(
        public string $configDirectoryPath,
        public ValueObjects\Server $fromOrbital,
        public ValueObjects\Server $messageStreamOrbital
    ) {

    }

    public static function new() : self
    {
        return new self(
            EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_CONFIG_DIRECTORY_PATH->toConfigValue(),
            ValueObjects\Server::new(
                EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_FROM_PROTOCOL->toConfigValue(),
                EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_FROM_HOST->toConfigValue(),
                EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_FROM_PORT->toConfigValue()
            ),
            ValueObjects\Server::new(
                EnvName::FLUX_ECO_MESSAGE_STREAM_ORBITAL_PROTOCOL->toConfigValue(),
                EnvName::FLUX_ECO_MESSAGE_STREAM_ORBITAL_HOST->toConfigValue(),
                EnvName::FLUX_ECO_MESSAGE_STREAM_ORBITAL_PORT->toConfigValue()
            )
        );
    }
}