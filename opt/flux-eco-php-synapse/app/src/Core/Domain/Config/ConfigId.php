<?php

namespace FluxEco\PhpSynapse\Core\Domain\Config;

final readonly class ConfigId
{
    private function __construct(
        string $applicationName,
        string $configItemName
    )
    {

    }

    public static function new(
        string         $applicationName,
        ConfigItemName $configItemName
    )
    {
        return new self(...get_defined_vars());
    }
}