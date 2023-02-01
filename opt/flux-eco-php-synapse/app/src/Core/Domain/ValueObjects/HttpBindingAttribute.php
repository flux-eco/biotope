<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

enum HttpBindingAttribute: string
{
    case PROTOCOL = "protocol";
    case HOST = "host";
    case PORT = "port";


    public function get(object $object): string
    {
        return $object->{$this->value};
    }

}