<?php

namespace FluxEco\PhpSynapse\Core\Ports;


use FluxEco\PhpSynapse\Core\Domain\ApplicationDefinitionAggregate;
use FluxEco\PhpSynapse\Core\Domain\Definition\DefinitionId;
use FluxEco\PhpSynapse\Core\Domain\Definition\BindingType;
use FluxEco\PhpSynapse\Core\Domain\Messages\ResponseMessage;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\LocationName;

final readonly class Service
{


    private function __construct(
        private ApplicationDefinitionAggregate $applicationDefinitionAggregate,
        private Outbounds                      $outbounds
    )
    {

    }


    public static function new(Outbounds $outbounds)
    {
        $applicationDefinitionAggregate = ApplicationDefinitionAggregate::new(
            DefinitionId::new($outbounds->getApplicationId(), $outbounds->getApplicationDefinitionFilePath(), "#")
        );

        return new self($applicationDefinitionAggregate, $outbounds);
    }

    public function request(string $operationName, object $payload): void
    {
        $this->applicationDefinitionAggregate->getRequestChannelHttpUrl("");
        /*
        if ($this->applicationDefinitionAggregate->requestChannelBindingTypeExists($operationName, BindingType::HTTP)) {
            $this->applicationDefinitionAggregate->getRequestChannelHttpUrl($operationName);
        }*/

        /*
        $receiver = $this->applicationDefinitionAggregate->askChannelReceiver($operationName);
        $address = $receiver->address;
        $parameters = $receiver->parameterMappings->getMappedData(LocationName::PAYLOAD, $payload);
        $bindingDefinition = $receiver->bindingDefinition;

        //$requestMessage =

        //->newRequestMessage($payload);

        $response = $this->outbounds->request($address, $parameters, $bindingDefinition, $requestMessage);

        return $receiver->messageMapping->newResponseMessage($response);*/
    }

    private function httpRequest(string $operationName, object $payload): ResponseMessage
    {

    }
}