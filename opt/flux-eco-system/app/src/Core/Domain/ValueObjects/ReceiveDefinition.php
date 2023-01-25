<?php

namespace FluxEco\System\Core\Domain\ValueObjects;

final readonly class ReceiveDefinition
{
    private function __construct(
        public string $channelName,
        public string $operationName,
        public array $bindings
    )
    {

    }

    public static function fromObject(
        object $object
    ): self
    {
        return new self(
            $object->channelName,
            $object->operationName,
            $object->bindings
        );
    }
}