<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;
enum ChannelType: string {
    case RECEIVES = "receives";
    case REQUESTS = "requests";
    case SENDS = "sends";
}