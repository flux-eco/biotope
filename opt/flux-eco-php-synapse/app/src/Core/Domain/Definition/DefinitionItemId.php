<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
final readonly class DefinitionItemId
{
    private function __construct(
        public DefinitionId $definitionId,
        public string       $path,
    )
    {

    }

    public static function new(
        DefinitionId $definitionId,
        string       $path,
    )
    {
        return new self(...get_defined_vars());
    }
}