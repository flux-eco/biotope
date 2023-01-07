<?php

namespace FluxEco\MessageDispatcherSidecar\Adapters\Api;

use FluxEco\MessageDispatcherSidecar\Core\Ports;
use FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;
use FluxEco\MessageDispatcherSidecar\Adapters\Config\Config;

final readonly class Api
{
    private function __construct(private Ports\Service $service)
    {

    }

    public static function new()
    {
        $config = Config::new();
        return new self(Ports\Service::new(
            Ports\Outbounds::new(
                $config->configDirectoryPath,
                ValueObjects\Server::new(
                    $config->fromProtocol,
                    $config->fromHost,
                    $config->fromPort
                ),

            )
        ));
    }

    public function dispatch(string $address, object $message) : void
    {

    }
}