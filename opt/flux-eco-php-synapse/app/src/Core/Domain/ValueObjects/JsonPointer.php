<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

final readonly  class JsonPointer {
    private function __construct(
        private string $pointer
    ) {

    }

    public static function fromLocationReference(
        LocationName $locationName,
        string $reference
    ) {
        $exploded = explode($locationName->value."#/",$reference);
        return new self($exploded[1]);
    }

    public function getData(object $object) {
        $pointerKeys = explode("/", $this->pointer);
        $value = $object;
        foreach($pointerKeys as $pointerKey) {
            $value = $this->getValue($value, $pointerKey);
        }

        return $value;
    }

    private function getValue(object $object, $pointerKey): mixed {
        //todo if we would read the schema also we could check the type
        return $object->{$pointerKey};
    }

}