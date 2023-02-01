<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum RequestChannel: string implements NodeItemDefinition
{
    case RECEIVER = "receiver";
    case MAPPINGS = "mappings";

    public function getNodeItemDefinitions(mixed $nodeItem): array
    {
        return match ($this) {
            self::RECEIVER => ReceiveChannel::cases(),
            default => []
        };
    }

    public function hasNodeItemDefinitions(): bool
    {
        return match ($this) {
            default => true
        };
    }

    public function getName(): string
    {
        return $this->value;
    }

    public function getReference(string $documentReference, string $operationName): string
    {
        return Channels::REQUESTS->getReference($documentReference) . "/" . $operationName . "/" . $this->value;
    }

    public function getReceiverReference(string $documentReference, string $operationName, BindingType $bindingType): string
    {
        return Channels::REQUESTS->getReference($documentReference) . "/" . $operationName . "/" . $this->value ."/".ReceiveChannel::BINDINGS->value ."/".$bindingType->value;
    }
}