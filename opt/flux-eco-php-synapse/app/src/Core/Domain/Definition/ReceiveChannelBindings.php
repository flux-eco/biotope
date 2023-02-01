<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum ReceiveChannelBindings: string implements NodeItemDefinition
{
    case HTTP = "http";


    public function getNodeItemDefinitions(mixed $nodeItem): array
    {
        return match ($this) {
            self::HTTP => HttpReceiveChannelBindings::cases(),
        };
    }

    public function hasNodeItemDefinitions(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->value;
    }

}