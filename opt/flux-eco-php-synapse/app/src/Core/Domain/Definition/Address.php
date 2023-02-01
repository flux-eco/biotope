<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum Address: string implements NodeItemDefinition
{
    case PATH = "path";
    case PARAMETERS = "parameters";

    public function getNodeItemDefinitions(object $nodeItem): array
    {
        return match ($this) {
            default => []
        };
    }

    public function hasNodeItemDefinitions(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return $this->value;
    }

    public function getReference(string $documentReference, string $operationName): string
    {
        return Channels::RECEIVES->getReference($documentReference) . "/" . $operationName . "/" . $this->value;
    }
}