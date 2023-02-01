<?php

namespace FluxEco\PhpSynapse\Core\Domain\Http;
use WeakMap;

enum HttpMessageBindingAttribute: string
{
    case METHOD = "method";
    case ACCEPT = "accept";
    case AUTHORIZATION = "authorization";
    case CONTENT_DISPOSITION = "content-disposition";
    case CONTENT_TYPE = "content-type";
    case LOCATION = "location";
    case USER_AGENT = "user-agent";
    case WWW_AUTHENTICATE = "www-authenticate";
    case X_ACCEL_REDIRECT = "x-accel-redirect";
    case X_HTTP_METHOD_OVERRIDE = "x-http-method-override";
    case X_SENDFILE = "x-sendfile";



    public function has(WeakMap $object): bool
    {
        return $object->offsetExists($this);
    }

    public function get(WeakMap $object): string
    {
        return $object->offsetGet($this);
    }
}