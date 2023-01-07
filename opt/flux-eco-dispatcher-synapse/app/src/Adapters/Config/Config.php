<?php

namespace FluxEco\MessageDispatcherSidecar\Adapters\Config;

final readonly class Config
{
    private function __construct(
        public string $configDirectoryPath,
        public string $fromProtocol,
        public string $fromHost,
        public string $fromPort,
    ) {

    }

    public static function new() : self
    {
        return new self(
            EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_CONFIG_DIRECTORY_PATH->toConfigValue(),
            EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_FROM_PROTOCOL->toConfigValue(),
            EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_FROM_HOST->toConfigValue(),
            EnvName::FLUX_ECO_DISPATCHER_SYNAPSE_FROM_PORT->toConfigValue()
        );
    }
}