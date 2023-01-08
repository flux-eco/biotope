<?php

namespace FluxEco\DispatcherSynapse\Adapters\Api;

use FluxEco\DispatcherSynapse\Core\Ports;
use FluxEco\DispatcherSynapse\Adapters\Config\Config;
use FluxEco\DispatcherSynapse\Adapters\Publisher\HttpMessagePublisher;
use Exception;

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
                $config->fromOrbital,
                $config->messageStreamOrbital,
                HttpMessagePublisher::new()
            )
        ));
    }

    /**
     * @throws Exception
     */
    public function dispatch(string $addressPath, object $message) : void
    {
        $config = Config::new();
        $this->service->dispatchMessage(Ports\IncomingMessages\DispatchMessage::new(
            $addressPath, $message
        ));
    }
}