<?php

namespace FluxEco\System\Core\Ports;

use FluxEco\System\Core\Domain\FluxEcoSystemAggregate;
use FluxEco\System\Core\Domain\MessageRecorder;

final readonly class Service
{


    private function __construct(
        private object                 $operationApi,
        private FluxEcoSystemAggregate $ecoSystemAggregate
    )
    {

    }

    public static function new(object $operationApi)
    {
        return new self($operationApi, FluxEcoSystemAggregate::new(MessageRecorder::new()));
    }

    public function connectApplication(object $applicationDefinitionObject) {
        $this->ecoSystemAggregate->connectApplication($applicationDefinitionObject);
    }

    public function receive(string $address, object $data): void
    {
        $this->ecoSystemAggregate->
    }
}