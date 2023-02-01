<?php

namespace FluxEco\PhpSynapse\Adapters\Outbounds;

use FluxEco\PhpSynapse\Core\Domain\Definition\DefinitionItemType;
use FluxEco\PhpSynapse\Core\Domain\Definition\Info;

final readonly class DefinitionItemAdapter
{

    private function __construct(private string $schemaDirectoryPath)
    {

    }

    public static function new(string $schemaDirectoryPath)
    {
        return new self(...get_defined_vars());
    }

    public function toDefinitionItem(object $definitionDocument, DefinitionItemType $definitionItemType): Info
    {
        $schemaObject = json_decode(file_get_contents($this->schemaDirectoryPath . "/" . $definitionItemType->value . ".json"));
        $propertyNames = array_keys($schemaObject->properties);
        $props = array_intersect_key((array)$definitionDocument, array_flip($propertyNames));
        return Info::new(...$props);
    }

}