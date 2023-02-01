<?php

namespace FluxEco\PhpSynapse\Core\Domain\Mappings;

use FluxEco\PhpSynapse\Core\Domain\ValueObjects\Location;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\LocationName;
use stdClass;


final readonly class Mappings
{
    private function __construct(
        private object $mappings
    )
    {

    }

    public static function fromObject(string $mappingDefinitionPropertyName, object $object): ?self
    {
        if (property_exists($object, $mappingDefinitionPropertyName) === false) {
            return null;
        }

        $mappingDefinition = $object->{$mappingDefinitionPropertyName};

        $mappings = new stdClass();
        foreach ((array)$mappingDefinition as $key => $value) {
            $mappings->{$key} = Location::fromString($value);
        }
        return new self($mappings);
    }

    public function get(string $key)
    {
        return $this->mappings->{$key};
    }

    public function getMappedData(LocationName $locationName, object $object): object
    {
        $mappedData = new stdClass();
        foreach ($this->mappings as $key => $location) {
            /** @var Location $location */
            if ($location->name === $locationName) {
                $mappedData->{$key} = $location->jsonPointer->getData($object);
            }
        }
        return $mappedData;
    }

}