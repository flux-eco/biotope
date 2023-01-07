<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Domain\OutgoingMessages;

enum MessageName: string {
    case PUBLISH = "publish";
}