<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
enum ChannelType: string
{
    case RECEIVES = "receives";
    case REQUESTS = "requests";
    case SENDS = "sends";
}