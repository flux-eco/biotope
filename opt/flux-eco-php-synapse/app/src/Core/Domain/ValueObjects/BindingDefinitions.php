<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

use FluxEco\PhpSynapse\Core\Domain\Binding\BindingType;
use WeakMap;

final readonly class BindingDefinitions
{
    private function __construct(
        private WeakMap $bindings
    )
    {

    }

    public static function new(): self
    {
        $bindings = new WeakMap();
        return new self(
            $bindings
        );
    }

    public function append(BindingType $bindingType, object $binding)
    {
        $this->bindings->offsetSet($bindingType, BindingDefinition::new($bindingType, $binding));
    }

    public function get(BindingType $bindingType): BindingDefinition
    {
        return $this->bindings->offsetGet($bindingType);
    }
}