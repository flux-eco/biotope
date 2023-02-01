<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

final readonly class JsonSchemaNodeItemDefinition implements NodeItemDefinition
{
    private function __construct(
        private string $nodeName, private array $nodeItemDefinitions
    )
    {

    }

    /**
     * @param string $nodeName
     * @param NodeItemDefinition[] $nodeItemDefinitions
     * @return JsonSchemaNodeItemDefinition
     */
    public static function new(
        string $nodeName, array $nodeItemDefinitions
    )
    {
        return new self($nodeName, $nodeItemDefinitions);
    }



    public function getNodeItemDefinitions(mixed $nodeItem): array
    {
        return $this->nodeItemDefinitions;
    }

    public function hasNodeItemDefinitions(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->nodeName;
    }
}