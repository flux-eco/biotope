<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

final readonly class ApplicationDefinition
{

    private function __construct(
        public string $id,
        public array $receives,
        public array $sends,
    )
    {

    }

    public static function new(
        string $id,
        array $receives,
        array $sends,
    ) {
        return new self($id, $receives, $sends);
    }
}