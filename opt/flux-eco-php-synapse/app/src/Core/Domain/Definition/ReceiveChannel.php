<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum ReceiveChannel: string implements NodeItemDefinition
{
    case ADDRESS = "address";
    case BINDINGS = "bindings";


    public function getNodeItemDefinitions(mixed $nodeItem): array
    {
        return match ($this) {
            self::ADDRESS => Address::cases(),
            self::BINDINGS => ReceiveChannelBindings::cases()
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

    public function getReference(string $documentReference, string $operationName): string
    {
        return Channels::RECEIVES->getReference($documentReference) . "/" . $operationName . "/" . $this->value;
    }
}