<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;
enum LocationName: string
{
    case PAYLOAD = '$payload';
    case RESPONSE = '$response';
}