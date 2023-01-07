<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

use Exception;

final readonly class From
{
    private function __construct(
        public Server $server
    ) {

    }

    /**
     * @throws Exception
     */
    public static function new(Server $server) : self
    {
        return new self(
            ...get_defined_vars()
        );
    }

    public function toHeader() : string
    {
        return 'x-flux-eco-orbital: ' . $this->server->toString();
    }
}