<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Domain\OutgoingMessages;

use  FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

final readonly class PublishMessage
{
    private function __construct(
        public ValueObjects\CorrelationId $correlationId,
        public ValueObjects\MessageId $messageId,
        public ValueObjects\From $from,
        public ValueObjects\To $address,
        public object $messagePayload
    ) {

    }

    public static function new(
        ValueObjects\CorrelationId $correlationId,
        ValueObjects\MessageId $messageId,
        ValueObjects\From $from,
        ValueObjects\To $address,
        object $messagePayload
    ) : self {
        return new self(
            ...get_defined_vars()
        );
    }
}