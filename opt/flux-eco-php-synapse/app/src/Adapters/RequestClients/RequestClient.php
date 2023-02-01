<?php

namespace FluxEco\PhpSynapse\Adapters\RequestClients;

use FluxEco\PhpSynapse\Core\Domain\Messages\RequestMessage;
use FluxEco\PhpSynapse\Core\Domain\Messages\ResponseMessage;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\BindingDefinition;
use WeakMap;

interface RequestClient
{
    public function request(string $address, object $parameters, BindingDefinition $bindingDefinition, RequestMessage $requestMessage): ResponseMessage;
}