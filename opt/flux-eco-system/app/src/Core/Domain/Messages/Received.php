<?php

namespace FluxEco\HttpSynapse\Core\Domain\Messages;

final readonly class Received
{
    private function __construct(
        public string $operationName,
        public object $payload
    )
    {

    }

    public static function new(
        string $operationName, object $payload
    )
    {
        return new self(...get_defined_vars());
    }

    public function toArray(): array
    {
        return (array)$this;
    }
}