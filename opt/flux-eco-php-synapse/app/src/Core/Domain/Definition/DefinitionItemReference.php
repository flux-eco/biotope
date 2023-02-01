<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

use WeakMap;

class DefinitionItemReference
{
    private function __construct(
        public string $ref
    )
    {

    }

    public static function new(string $ref)
    {
        return new self($ref);
    }

    public static function fromItemPath(string $itemPath)
    {
        return new self("#/" . $itemPath);
    }

    public static function fromBoundedItemPath(string $applicationName, string $itemPath)
    {
        return new self($applicationName . "#/" . $itemPath);
    }
}