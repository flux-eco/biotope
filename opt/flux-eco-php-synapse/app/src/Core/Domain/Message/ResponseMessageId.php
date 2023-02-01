<?php

namespace FluxEco\PhpSynapse\Core\Domain\Address;

use FluxEco\PhpSynapse\Core\Domain\Binding\BindingType;
use FluxEco\PhpSynapse\Core\Domain\Operation\OperationType;

class ResponseMessageId
{
    private function __construct(
        public string        $applicationName,
        public OperationType $operationType,
        public string        $operationName,
        public BindingType   $bindingType,
        string               $messageName
    )
    {

    }

    public static function new(string        $applicationName,
                               OperationType $operationType,
                               string        $operationName,
                               BindingType   $bindingType,
                               string        $messageName): self
    {
        return new self(...get_defined_vars());
    }
}