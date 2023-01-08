<?php

namespace FluxEco\DispatcherSynapse\Core\Ports\Publisher;
use FluxEco\DispatcherSynapse\Core\Domain;

interface MessagePublisher {
    public function  publish(Domain\OutgoingMessages\PublishMessage $message);
}
