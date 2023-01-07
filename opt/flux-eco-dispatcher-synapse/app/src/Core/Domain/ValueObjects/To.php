<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

class To
{
    private function __construct(
        public string $addressPath,
        public Server $server
    ) {

    }

    public static function new(
        string $addressPath,
        Server $server
    ) : self {
        return new self(...get_defined_vars());
    }

    public function toUrl() : string
    {
        return $this->server->toString() . "To.php/" . $this->addressPath;
    }
}