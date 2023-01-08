<?php

namespace FluxEco\DispatcherSynapse\Core\Domain;
use FluxEco\DispatcherSynapse\Core\Domain\OutgoingMessages\PublishMessage;

final readonly class MessagePublisherAggregate
{
    private function __construct(
        public MessageRecorder $messageRecorder,
        public ValueObjects\CorrelationId $correlationId
    ) {

    }

    public static function new(
        ValueObjects\CorrelationId $correlationId
    ) : self {
        return new self(MessageRecorder::new(), $correlationId);
    }

    public function publish(
        ValueObjects\MessageId $messageId,
        ValueObjects\From $from,
        ValueObjects\To $to,
        object $message
    ) : void {
        $this->messageRecorder->record(
            $messageId->id,
            PublishMessage::new(
                $this->correlationId,
                $messageId,
                $from,
                $to,
                $message
            )
        );
    }

}