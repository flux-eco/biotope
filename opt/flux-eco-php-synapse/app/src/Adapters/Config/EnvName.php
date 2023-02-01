<?php

namespace FluxEco\PhpSynapse\Adapters\Config;

enum EnvName: string
{
    case FLUX_ECO_PHP_APPLICATION_DEFINITION_FILE_PATH = 'FLUX_ECO_PHP_APPLICATION_DEFINITION_FILE_PATH';
    case FLUX_ECO_PHP_APPLICATION_DEFINITION_CONFIG_FILE_PATH = 'FLUX_ECO_PHP_APPLICATION_DEFINITION_CONFIG_FILE_PATH';


    public function toConfigValue() : string|int
    {
        return getenv($this->value);
    }
}