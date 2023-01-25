<?php

namespace FluxEco\System\Core\Domain;

use FluxEco\System\Core\Domain\ValueObjects\ApplicationDefinition;
use FluxEco\System\Core\Domain\ValueObjects\ApplicationDefinitionAttributeName;
use FluxEco\System\Core\Domain\ValueObjects\ReceiveDefinition;

class FluxEcoSystemAggregate
{
    /**
     * @param MessageRecorder $messageRecorder
     * @param ApplicationDefinition[] $applications
     */
    private function __construct(
        public MessageRecorder $messageRecorder,
        private array $applications
    )
    {

    }

    public static function new(
        MessageRecorder $messageRecorder,
    )
    {
        return new self(
            $messageRecorder,
            []
        );
    }

    public function connectApplication(object $applicationDefinitionObject) {

        $receiveDefinitions = [];
        if(count($applicationDefinitionObject->{ApplicationDefinitionAttributeName::RECEIVES->value}) > 0) {
            foreach($applicationDefinitionObject->{ApplicationDefinitionAttributeName::RECEIVES->value} as $key => $value) {
                $receiveDefinitions[$key] = ReceiveDefinition::fromObject($value);
            }
        }


        $this->applyApplicationConnected(
            ApplicationDefinition::new(
                $applicationDefinitionObject->{ApplicationDefinitionAttributeName::ID->value},



            )
        );
    }

    private function applyApplicationConnected(ApplicationDefinition $applicationDefinition) {

    }

}