<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

use FluxEco\PhpSynapse\Core\Domain\Binding\BindingType;

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