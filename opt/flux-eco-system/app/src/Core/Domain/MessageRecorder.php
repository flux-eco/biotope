<?php

namespace FluxEco\System\Core\Domain;


class MessageRecorder
{
    private function __construct(private array $messages)
    {

    }

    public static function new()
    {
        return new self([]);
    }

    public function record(string $messageName, object $payload)
    {
        $this->messages[$messageName] = $payload;
    }

    public function getAndFlush(): array
    {
        $messages = $this->messages;
        $this->messages = [];
        return $messages;
    }

}