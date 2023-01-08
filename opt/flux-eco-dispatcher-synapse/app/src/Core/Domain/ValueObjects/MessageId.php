<?php

namespace FluxEco\DispatcherSynapse\Core\Domain\ValueObjects;

use Exception;

final readonly class MessageId
{
    private function __construct(
        public string $id,
        public IdType $idType
    ) {

    }

    public static function newUuid4() : self
    {
        $idType = IdType::MESSAGE_ID;

        return new self(
            $idType->generateId(),
            $idType
        );
    }
}