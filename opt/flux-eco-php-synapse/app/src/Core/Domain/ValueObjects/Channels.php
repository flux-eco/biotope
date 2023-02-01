<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

use FluxEco\PhpSynapse\Core\Domain\Channels\RequestChannelDefinition;
use stdClass;
use WeakMap;

final readonly  class Channels
{
    private function __construct(
        private WeakMap $channels
    )
    {

    }

    public static function new(): self
    {
        $channels = new WeakMap();
        $channels->offsetSet(ChannelType::RECEIVES, new stdClass());
        $channels->offsetSet(ChannelType::REQUESTS, new stdClass());
        $channels->offsetSet(ChannelType::SENDS, new stdClass());

        return new self(
            $channels
        );
    }

    public function requestChannelReceiver(string $operationName): ReceiverMapping
    {
        return $this->channels->offsetGet(ChannelType::REQUESTS)->{$operationName};
    }


    public function appendReceiveChannel(string $operationName, ReceiveDefinition $receiverDefinition)
    {
        $this->appendChannel($operationName, ChannelType::RECEIVES, $receiverDefinition);
    }

    public function appendRequestChannelDefinition(string $operationName, RequestChannelDefinition $requestChannelDefinition)
    {
        $this->appendChannel($operationName, ChannelType::REQUESTS, $requestChannelDefinition);
    }
    public function appendSendsChannel(string $operationName, ReceiverMapping $receiverMapping)
    {
        $this->appendChannel($operationName, ChannelType::SENDS, $receiverMapping);
    }

    private function appendChannel(string $operationName, ChannelType $channelType, $receiver)
    {
        $channels = $this->channels->offsetGet($channelType);
        $channels->{$operationName} = $receiver;
        $this->channels->offsetSet($channelType, $channels);
    }
}