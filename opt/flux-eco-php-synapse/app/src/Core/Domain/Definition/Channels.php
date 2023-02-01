<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum Channels: string implements NodeItemDefinition
{
    case RECEIVES = "receives";
    case REQUESTS = "requests";
    case SENDS = "sends";

    public function getNodeItemDefinitions(object $nodeItem): array
    {
        return match ($this) {
            self::RECEIVES => $this->createNodeItemDefinitions($nodeItem, ReceiveChannel::cases()),
            self::REQUESTS => $this->createNodeItemDefinitions($nodeItem, RequestChannel::cases()),
            self::SENDS => $this->createNodeItemDefinitions($nodeItem, SendChannel::cases()),
        };
    }

    private function createNodeItemDefinitions(object $nodeItem, array $nodeItemDefinitions)
    {
        $definitions = [];
        foreach (get_object_vars($nodeItem) as $propertyName => $value) {
            $definitions[] = JsonSchemaNodeItemDefinition::new($propertyName, $nodeItemDefinitions);
        }
        return $definitions;
    }

    public function hasNodeItemDefinitions(): bool
    {
        return match ($this) {
            self::RECEIVES, self::REQUESTS, self::SENDS => true
        };
    }

    public function getName(): string
    {
        return $this->value;
    }

    public function getReference(string $documentReference): string {
        return ApplicationNode::CHANNELS->getReference($documentReference)."/".$this->value;
    }
}