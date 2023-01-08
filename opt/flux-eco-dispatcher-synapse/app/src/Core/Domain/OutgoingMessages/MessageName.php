<?php

namespace FluxEco\DispatcherSynapse\Core\Domain\OutgoingMessages;

enum MessageName: string {
    case PUBLISH = "publish";
}