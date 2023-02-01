<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
final readonly class Info
{
    private function __construct(
        public string         $id,
        public string         $version,
        public TechnologyType $technology
    )
    {

    }

    public static function new(
        string $definitionId,
        string $version,
        string $technology
    ): self
    {
        return new self($definitionId, $version, TechnologyType::from($technology));
    }
}