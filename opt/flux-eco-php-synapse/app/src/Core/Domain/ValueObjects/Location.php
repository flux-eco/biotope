<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

final readonly  class Location
{
    private function __construct(
        public LocationName $name,
        public JsonPointer  $jsonPointer
    )
    {

    }

    public static function new(
        LocationName $name,
        JsonPointer  $jsonPointer
    )
    {
        return new self(...get_defined_vars());
    }

    public static function fromString(
        string $location,
    )
    {
        if (str_contains($location, LocationName::PAYLOAD->value)) {
            return new self(
                LocationName::PAYLOAD,
                JsonPointer::fromLocationReference(LocationName::PAYLOAD, $location)
            );
        }
    }

}