<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;

enum Message: string
{
    case HEADERS = "headers";
    case CONTENT = "content";
}