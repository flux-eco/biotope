<?php

namespace FluxEco\PhpSynapse\Core\Domain\Operation;
enum MessageType: string
{
    case REQUEST_MESSAGE = "requestMessage";
    case RESPONSE_MESSAGE = "responseMessage";
}