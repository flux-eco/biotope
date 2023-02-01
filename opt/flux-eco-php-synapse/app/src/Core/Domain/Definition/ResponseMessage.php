<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum ResponseMessage: string implements NodeItemDefinition
{
    case HEADERS = "headers";
    case CONTENT = "content";


    public function getNodeItemDefinitions(object $nodeItem): array
    {
       return [];
    }

    public function hasNodeItemDefinitions(): bool
    {
       return false;
    }

    public function getName(): string
    {
        return $this->value;
    }
}