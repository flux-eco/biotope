<?php

namespace FluxEco\PhpSynapse\Core\Domain\Address;

use FluxEco\PhpSynapse\Core\Domain\Operation\OperationType;

class AddressId
{
    private function __construct(
        public string        $applicationName,
        public OperationType $operationType,
        public string        $operationName,
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