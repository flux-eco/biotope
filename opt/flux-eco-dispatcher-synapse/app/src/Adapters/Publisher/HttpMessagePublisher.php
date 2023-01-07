<?php

namespace FluxEco\MessageDispatcherSidecar\Adapters\Publisher;

use FluxEco\MessageDispatcherSidecar\Core\Ports;
use FluxEco\MessageDispatcherSidecar\Core\Domain;

final readonly class HttpMessagePublisher implements Ports\Publisher\MessagePublisher
{

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }

    public function publish(Domain\OutgoingMessages\PublishMessage $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $message->address->toUrl());
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $message->from->toHeader()]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message->messagePayload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}