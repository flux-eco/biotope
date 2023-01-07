<?php

namespace FluxEco\MessageDispatcherSidecar\Core\Domain\ValueObjects;

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
        $idType = IdType::UUID4;

        return new self(
            $idType->generateId(),
            $idType
        );
    }
}