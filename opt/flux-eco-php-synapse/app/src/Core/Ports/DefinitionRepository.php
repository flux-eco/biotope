<?php

namespace FluxEco\PhpSynapse\Core\Ports;

use FluxEco\PhpSynapse\Core\Domain\Definition;

interface DefinitionRepository
{
    public function getInformationNode(Definition\DefinitionId $definitionId): Definition\Info;

    public function getBinding(Definition\BindingType $bindingType): Definition\HttpBinding|Definition\PhpApiBinding|Definition\CliBinding;

    public function getOperation(Definition\OperationType $operationType, string $operationName): Definition\ReceiveOperation|Definition\RequestOperation|Definition\SendOperation;

    public function getChannel(Definition\ChannelType $channelType, string $channelPath): Definition\ReceiveChannel|Definition\RequestChannel|Definition\SendChannel;

    public function getSchema(string $schemaName): Definition\Schema;

    public function getDefaultValue(string $defaultValueName): Definition\Schema;


}