<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

use FluxEco\PhpSynapse\Core\Domain\Definition\DefinitionItemReference;
use FluxEco\PhpSynapse\Core\Domain\Operation\OperationType;
use WeakMap;

enum HttpChannelBinding: string
{
    case SERVER = "server";
    case QUERY_PARAMETERS = "queryParameters";

    public function toItemPath(OperationType $operationType, string $operationName)
    {
        return ChannelId::new(OperationType::REQUESTS, $operationName)->toItemPath() . "/" . $this->value;
    }


    public function toReferene(OperationType $operationType, string $operationName)
    {
        return DefinitionItemReference::fromItemPath(ChannelId::new(OperationType::REQUESTS, $operationName)->toItemPath() . "/" . $this->value)->ref;
    }
}