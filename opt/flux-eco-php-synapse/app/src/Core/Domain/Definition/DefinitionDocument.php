<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

final readonly class DefinitionDocument
{
    private function __construct(
        public string $definitionId,
        public object $definitionNode
    )
    {

    }

    public static function new(
        string $definitionId,
        object $definitionNode
    ): self
    {
        return new self(...get_defined_vars());
    }


}