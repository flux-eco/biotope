<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum HttpReceiveChannelBindings: string implements NodeItemDefinition
{
    case SERVER = "server";
    case METHOD = "method";
    case QUERY = "query";
    case REQUEST_MESSAGE = "requestMessage";
    case RESPONSE_MESSAGES = "responseMessages";


    public function getNodeItemDefinitions(mixed $nodeItem): array
    {
        return match ($this) {
            self::SERVER => HttpServer::cases(),
            self::REQUEST_MESSAGE => RequestMessage::cases()
        };
    }



    public function hasNodeItemDefinitions(): bool
    {
        return match ($this) {
            self::SERVER => true,
            self::REQUEST_MESSAGE => true,
            default => false
        };
    }

    public function getName(): string
    {
        return $this->value;
    }


}