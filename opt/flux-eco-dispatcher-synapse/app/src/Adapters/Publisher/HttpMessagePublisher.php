<?php

namespace FluxEco\DispatcherSynapse\Adapters\Publisher;

use FluxEco\DispatcherSynapse\Core\Ports;
use FluxEco\DispatcherSynapse\Core\Domain;

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
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $message->from->toHeader(), $message->correlationId->toHeader()]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message->messagePayload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}