<?php

namespace FluxEco\System\Core\Domain\ValueObjects;
enum ApplicationDefinitionAttributeName: string
{
    case ID = "id";
    case RECEIVES = "receives";
    case SENDS = "sends";
}