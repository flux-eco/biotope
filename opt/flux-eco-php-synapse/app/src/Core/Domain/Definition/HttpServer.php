<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum HttpServer: string implements NodeItemDefinition
{
    case PROTOCOL = "protocol";
    case HOST = "host";
    case PORT = "port";


    public function getNodeItemDefinitions(object $nodeItem): array
    {

    }

    public function hasNodeItemDefinitions(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return "server";
    }
}