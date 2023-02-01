<?php

namespace FluxEco\PhpSynapse\Adapters\Api;

use FluxEco\PhpSynapse\Adapters\Config\Config;
use FluxEco\PhpSynapse\Adapters\Outbounds\OutboundsAdapter;
use FluxEco\PhpSynapse\Core\Domain\Messages\ResponseMessage;
use FluxEco\PhpSynapse\Core\Ports\Service;

final readonly class PhpSynapseApi
{

    private function __construct(
        private Service $service
    ) {

    }

    public static function new() : self
    {
        return new self(
            Service::new(
                OutboundsAdapter::new(Config::new())
            )
        );
    }

    final public function request(string $operationName, object $payload): void {
        $this->service->request($operationName, $payload);
    }

    final public function receive(string $address, object $payload, ): void
    {
        $this->service->receive($address, $payload);
    }

    final public function send() {

    }
}