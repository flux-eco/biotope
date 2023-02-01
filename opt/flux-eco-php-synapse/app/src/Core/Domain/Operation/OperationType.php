<?php

namespace FluxEco\PhpSynapse\Core\Domain\Operation;
enum OperationType: string
{
    case RECEIVES = "receives";
    case REQUESTS = "requests";
    case SENDS = "sends";
}