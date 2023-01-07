<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Domain;

use stdClass;

final class MessageRecorder
{
    /**
     * @param OutgoingMessages\PublishMessage[] $recordedMessages
     */
    private function __construct(
        public array $recordedMessages = []
    ) {

    }

    public static function new() : self
    {
        return new self();
    }

    public function record(string $messageId, OutgoingMessages\PublishMessage $publishMessage) : void
    {
        $this->recordedMessages[$messageId] = $publishMessage;
    }

    public function flush() : void
    {
        $this->recordedMessages = [];
    }
}