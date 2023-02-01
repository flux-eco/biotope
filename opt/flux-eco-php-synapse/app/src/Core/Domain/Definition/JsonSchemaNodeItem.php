<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

final readonly class JsonSchemaNodeItem implements NodeItemDefinition
{
    private function __construct(
        private string $nodeName
    )
    {

    }

    /**
     * @param string $nodeName
     * @return JsonSchemaNodeItem
     */
    public static function new(
        string $nodeName
    )
    {
        return new self($nodeName);
    }


    public function getNodeItemDefinitions(object $nodeItem): array
    {
        $definitions = [];
        foreach((array)$nodeItem as $key => $value) {
            if(is_object($value)) {
                $definitions[] = new self($key);
            }
        }

        return $definitions;
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