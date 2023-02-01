<?php

namespace FluxEco\PhpSynapse\Adapters\Config;

use FluxEco\PhpSynapse\Adapters\RequestClients\HttpRequestClient;
use FluxEco\PhpSynapse\Adapters\RequestClients\RequestClient;
use FluxEco\PhpSynapse\Core\Domain\Definition\BindingType;
use WeakMap;

final readonly class Config
{

    private function __construct(
        public string   $applicationName,
        public string   $applicationDefinitionFilePath,
        public string   $applicationConfigDefinitionFilePath,
        private WeakMap $requestClients
    )
    {

    }

    public static function new(): self
    {
        $requestClients = new WeakMap();
        $requestClients->offsetSet(BindingType::HTTP, HttpRequestClient::new());

        /*return new self(
            EnvName::FLUX_ECO_PHP_APPLICATION_DEFINITION_FILE_PATH->toConfigValue(),
            EnvName::FLUX_ECO_PHP_APPLICATION_DEFINITION_CONFIG_FILE_PATH->toConfigValue(),
            $requestClients
        );*/

        return new self(
            "flux-eco-ilias-user-orbital.json",
            __DIR__."/../../../definitions/flux-eco-ilias-user-orbital.json",
            __DIR__."/../../../definitions/flux-eco-ilias-user-orbital-config.json",
            $requestClients
        );
    }

    public function requestClient(BindingType $bindingType): RequestClient
    {
        return $this->requestClients->offsetGet($bindingType);
    }
}