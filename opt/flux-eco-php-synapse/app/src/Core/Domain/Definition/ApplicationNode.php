<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

use WeakMap;

enum ApplicationNode: string implements NodeItemDefinition
{
    case NAME = "name";
    case VERSIOM = "version";
    case TECHNOLOGY = "technology";
    case SERVERS = "servers";
    case OPERATIONS = "operations";
    case CHANNELS = "channels";
    case VALUES = "values";
    case SCHEMAS = "schemas";

    public function toItemPath(): string
    {
        return $this->value;
    }

    public function getNodeItemDefinitions(mixed $nodeItem): array
    {
        return match ($this) {
            self::OPERATIONS => [],
            self::CHANNELS => Channels::cases()
        };
    }

    public function hasNodeItemDefinitions(): bool
    {
        return match ($this) {
            self::NAME => false,
            self::VERSIOM => false,
            self::TECHNOLOGY => false,
            self::SERVERS => false,
            self::OPERATIONS => true,
            self::CHANNELS => true,
            self::VALUES => false,
            self::SCHEMAS => false,
        };
    }

    public function getName(): string
    {
        return $this->value;
    }

    public function getReference(string $documentReference): string
    {
        return $documentReference ."/".$this->value;
    }
}