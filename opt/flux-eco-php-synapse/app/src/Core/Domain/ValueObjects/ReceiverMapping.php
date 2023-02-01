<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

use FluxEco\PhpSynapse\Core\Domain\Mappings\Mappings;

final readonly  class ReceiverMapping {
    private function __construct(
        public string $address,
        public Mappings $parameterMappings,
        public BindingDefinition $bindingDefinition,
        public ?Mappings $requestMessageMappings,
        public ?Mappings $responseMessageMappings
    ) {

    }

    public static function new(
        string $address,
        Mappings $parameterMappings,
        BindingDefinition $bindingDefinition,
        ?Mappings $requestMessageMappings,
        ?Mappings $responseMessageMappings
    ) {
        return new self(...get_defined_vars());
    }

}