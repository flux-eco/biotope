<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Ports;

use FluxEco\MessageDispatcherSidecar\Core\Domain;
use Exception;
use stdClass;

final readonly class Service
{
    private function __construct(
        private Outbounds $outbounds
    ) {

    }

    public static function new(Outbounds $outbounds) : self
    {
        return new self($outbounds);
    }

    /**
     * @throws Exception
     */
    public function dispatchMessage(IncomingMessages\DispatchMessage $message) : void
    {
        $messagePublisherAggregate = Domain\MessagePublisherAggregate::new(
            Domain\ValueObjects\CorrelationId::newUuid4()
        );

        //publish to global message stream  e.g. for logging
        $messagePublisherAggregate->publish(Domain\ValueObjects\MessageId::newUuid4(), $message->from,
            Domain\ValueObjects\To::new($message->addressPath, $this->outbounds->messageStreamServer), $message);

        $nextMessages = $this->getNexMessages($message);
        if ($nextMessages === null) {
            $this->publishMessages($messagePublisherAggregate->messageRecorder);
            return;
        }

        foreach ($nextMessages as $nextMessage) {
            //publish to global message stream  e.g. for logging
            $messagePublisherAggregate->publish(Domain\ValueObjects\MessageId::newUuid4(), $message->from,
                Domain\ValueObjects\To::new($nextMessage->to->addressPath, $this->outbounds->messageStreamServer),
                $nextMessage);

            //publish transformed next message
            $messagePublisherAggregate->publish(Domain\ValueObjects\MessageId::newUuid4(), $message->from,
                $nextMessage->to, $nextMessage);
        }

    }

    private function publishMessages(Domain\MessageRecorder $messageRecorder) : void
    {
        if (count($messageRecorder->recordedMessages) > 0) {
            foreach ($messageRecorder->recordedMessages as $message) {
                $this->outbounds->messagePublisher->publish($message);
            }
        }
        $messageRecorder->flush();
    }

    /**
     * @param IncomingMessages\DispatchMessage $message
     * @return ?IncomingMessages\DispatchNextMessage[]
     */
    //todo -> refactor
    private function getNexMessages(IncomingMessages\DispatchMessage $message) : ?array
    {
        $filePath = $this->outbounds->dispatcherConfigPath . "/" . $message->addressPath . ".json";
        if ($this->fileExists($filePath) === false) {
            return null;
        }
        $messageConfig = json_decode(file_get_contents($filePath));

        $nextMessages = [];
        if (property_exists($messageConfig, "nextMessages")) {
            foreach ($messageConfig->nextMessages as $nextMessage) {

                if (property_exists($nextMessage, 'required') === true) {
                    $abort = false;
                    foreach ($nextMessage->required as $required) {
                        if (str_contains($required, '{$message.') === true) {
                            $propertyName = rtrim(ltrim($required, '{$message.'), '}');
                            if (property_exists($message,
                                    $propertyName) === false || $message->{$propertyName} === null || $message->{$propertyName} === "") {
                                $abort = true;
                            }
                        }
                    }
                    if ($abort === true) {
                        continue;
                    }
                }

                $addressPath = $nextMessage->address->path;
                if ($nextMessage->address->parameters !== null) {
                    foreach ((array) $nextMessage->address->parameters as $parameterName => $parameter) {
                        $addressPath = $this->replaceParameter($addressPath, $parameterName, $parameter, $message);
                    }
                }

                $messagePayload = $nextMessage->messagePayload;

                if (property_exists($messagePayload, '$merge') === true) {
                    if (str_contains($messagePayload->{'$merge'}, '{$message}') === true) {
                        unset($messagePayload->{'$merge'});
                        $messagePayload = (object) array_merge(
                            (array) $messagePayload, (array) $message);
                    }
                }

                if (property_exists($messagePayload, '$location') === true) {
                    if (str_contains($messagePayload->{'$location'}, '{$message}') === true) {
                        $messagePayload = $message;
                    }
                }

                if (property_exists($messagePayload, '$transform') === true) {
                    $properties = $messagePayload->{'$transform'};
                    $messagePayload = new stdClass();
                    foreach ($properties as $propertyKey => $propertyValue) {
                        if (str_contains($propertyValue, '{$message.') === true) {
                            $messagePropertyKey = rtrim(ltrim($propertyValue, '{$message.'), '}');
                            $propertyValue = $message->{$messagePropertyKey};
                        }
                        $messagePayload->{$propertyKey} = $propertyValue;
                    }
                }

                $nextMessages[] = IncomingMessages\DispatchNextMessage::new(
                    $message->from,
                    Domain\ValueObjects\To::new(
                        $addressPath,
                        Domain\ValueObjects\Server::new(
                            $nextMessage->address->server->protocol,
                            $nextMessage->address->server->url,
                            $nextMessage->address->server->port,
                        )
                    ),
                    $messagePayload
                );
            }
        }

        return $nextMessages;
    }

    private function replaceParameter(
        string $address,
        string $parameterName,
        object $parameter,
        IncomingMessages\DispatchMessage $message
    ) : string {
        if (str_contains($parameter->location, '{$message}') === true) {
            $location = ltrim($parameter->location, '{$message}');
            $messageAttributePath = explode('/', $location);
            $value = $message;
            foreach ($messageAttributePath as $attributeName) {
                $value = $value->{$attributeName};
            }
            $address = str_replace('{' . $parameterName . '}', $value, $address);
        }
        return $address;
    }

    private function fileExists(string $url) : bool
    {
        return str_contains(get_headers($url)[0], "200 OK");
    }

}