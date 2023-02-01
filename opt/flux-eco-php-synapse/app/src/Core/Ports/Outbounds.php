<?php

namespace FluxEco\PhpSynapse\Core\Ports;
use FluxEco\PhpSynapse\Core\Domain\Messages\RequestMessage;
use FluxEco\PhpSynapse\Core\Domain\Messages\ResponseMessage;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\BindingDefinition;
use WeakMap;

interface Outbounds
{

    function httpRequest(
        string  $address,
        object $parameters,
        BindingDefinition $bindingDefinition,
        RequestMessage $requestMessage
    ): ResponseMessage;

    public function getApplicationId(): string;
    public function getApplicationDefinitionFilePath(): string;

    public function getApplicationConfigDefinition(): WeakMap;

    public function getConfigs(): WeakMap;
}