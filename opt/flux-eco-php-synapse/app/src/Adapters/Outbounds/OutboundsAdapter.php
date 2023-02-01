<?php

namespace FluxEco\PhpSynapse\Adapters\Outbounds;

use FluxEco\PhpSynapse\Adapters\Config\Config;
use FluxEco\PhpSynapse\Core\Domain\Messages\RequestMessage;
use FluxEco\PhpSynapse\Core\Domain\Messages\ResponseMessage;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\BindingDefinition;
use FluxEco\PhpSynapse\Core\Ports\Outbounds;
use WeakMap;

final readonly class OutboundsAdapter implements Outbounds
{
    private function __construct(private Config $config) {

    }

    public static function new(
        Config $config
    ) {
        return new self($config);
    }

    function httpRequest(string $address, object $parameters, BindingDefinition $bindingDefinition, RequestMessage $requestMessage): ResponseMessage
    {
        return $this->config->requestClient($bindingDefinition->bindingType)->request(
            $address, $parameters, $bindingDefinition, $requestMessage
        );
    }

    public function getApplicationDefinition(): WeakMap
    {
        return $this->loadDefinition($this->config->applicationDefinitionFilePath);
    }

    public function getApplicationConfigDefinition(): WeakMap
    {
        return $this->loadDefinition($this->config->applicationConfigDefinitionFilePath);
    }

    private function loadDefinition(string $filePath): WeakMap {
        $definitionObject = json_decode(file_get_contents($filePath));
        $weakMap = new WeakMap();
        foreach ($definitionObject as $key => $value) {
            $weakMap->offsetSet(Application::from($key), $value);
        }
        return $weakMap;
    }


    public function getConfigs(): WeakMap
    {
        return new WeakMap();
    }

    public function getApplicationId(): string
    {
        return $this->config->applicationName;
    }

    public function getApplicationDefinitionFilePath(): string
    {
        return $this->config->applicationDefinitionFilePath;
    }
}