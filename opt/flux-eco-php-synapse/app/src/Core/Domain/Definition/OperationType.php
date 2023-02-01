<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
enum OperationType: string
{
    case RECEIVES = "receives";
    case REQUESTS = "requests";
    case SENDS = "sends";
}