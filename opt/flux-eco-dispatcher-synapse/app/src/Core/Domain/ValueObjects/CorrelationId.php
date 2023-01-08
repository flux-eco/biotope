<?php

namespace FluxEco\DispatcherSynapse\Core\Domain\ValueObjects;

use Exception;

final readonly class CorrelationId
{
    private function __construct(
        public string $id,
        public IdType $idType
    ) {

    }

    /**
     * @throws Exception
     */
    public static function newUuid4() : self
    {
        $idType = IdType::CORRELATION_ID;

        return new self(
            $idType->generateId(),
            $idType
        );
    }

    public function toHeader() : string
    {
        return 'x-flux-eco-'.$this->idType->value.': ' . $this->id;
    }
}