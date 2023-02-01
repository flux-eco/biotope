<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum SendChannel: string implements NodeItemDefinition
{
    case ADDRESS = "address";
    case BINDINGS = "bindings";
    case MESSAGES = "messages";


    public function getNodeItemDefinitions(object $nodeItem): array
    {
        return match ($this) {
            default => []
        };
    }

    public function hasNodeItemDefinitions(): bool
    {
        return match ($this) {
            default => false
        };
    }

    public function getName(): string
    {
        return $this->value;
    }
}