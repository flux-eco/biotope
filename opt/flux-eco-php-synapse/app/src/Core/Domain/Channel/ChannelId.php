<?php

namespace FluxEco\PhpSynapse\Core\Domain\Channel;

use FluxEco\PhpSynapse\Core\Domain\ApplicationDefinition\Application;
use FluxEco\PhpSynapse\Core\Domain\Bindings;
use FluxEco\PhpSynapse\Core\Domain\Operation;

final readonly class ChannelId
{
    private function __construct(
        public Operation\OperationType $operationType,
        public string                  $operationName
    )
    {

    }

    public static function new(
        Operation\OperationType $operationType,
        string                  $operationName
    )
    {
        return new self(...get_defined_vars());
    }

    public function toItemPath(): string
    {
        return Application::CHANNELS->toItemPath() . "/" . $this->operationType->value . "/" . $this->operationName;
    }
}