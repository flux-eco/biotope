<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
final readonly class DefinitionId
{
    private function __construct(
        public string $definitionId,
        public string $definitionDocumentFilePath,
        public string $documentNode
    )
    {

    }

    public static function new(
        string $definitionId,
        string $definitionDocumentFilePath,
        string $documentNode
    )
    {
        return new self(...get_defined_vars());
    }
}