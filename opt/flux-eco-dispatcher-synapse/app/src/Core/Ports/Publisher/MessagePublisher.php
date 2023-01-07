<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Ports\Publisher;
use FluxEco\MessageDispatcherSidecar\Core\Domain;

interface MessagePublisher {
    public function  publish(Domain\OutgoingMessages\PublishMessage $message);
}
