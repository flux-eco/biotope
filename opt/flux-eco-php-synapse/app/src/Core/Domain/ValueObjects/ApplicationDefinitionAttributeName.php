<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;
enum ApplicationDefinitionAttributeName: string
{
    case ID = "id";
    case RECEIVES = "receives";
    case SENDS = "sends";
}