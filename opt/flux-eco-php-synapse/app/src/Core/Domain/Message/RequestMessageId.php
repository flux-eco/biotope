<?php

namespace FluxEco\PhpSynapse\Core\Domain\Address;

use FluxEco\PhpSynapse\Core\Domain\Binding\BindingType;
use FluxEco\PhpSynapse\Core\Domain\Operation\OperationType;

class RequestMessageId
{
    private function __construct(
        public string        $applicationName,
        public OperationType $operationType,
        public string        $operationName,
        public BindingType   $bindingType
    )
    {

    }

    public static function new(string        $applicationName,
                               OperationType $operationType,
                               string        $operationName): self
    {
        return new self(...get_defined_vars());
    }
}