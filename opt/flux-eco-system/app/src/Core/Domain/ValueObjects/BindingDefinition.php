<?php

namespace FluxEco\System\Core\Domain\ValueObjects;

final readonly class BindingDefinition
{
    private function __construct(
        public BindingType $bindingType,
        public object      $bindingAttributes,
    )
    {

    }

    public static function new(
        BindingType $bindingType,
        object      $bindingAttributes,
    ): self
    {
        return new self($bindingType, $bindingAttributes);
    }
}