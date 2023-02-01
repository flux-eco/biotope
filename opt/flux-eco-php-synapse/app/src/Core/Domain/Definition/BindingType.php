<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
enum BindingType: string
{
    case HTTP = "http";
    case CLI = "cli";
    case PHP_API = "phpApi";
}