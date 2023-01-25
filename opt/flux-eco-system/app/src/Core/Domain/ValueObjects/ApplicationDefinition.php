<?php

namespace FluxEco\System\Core\Domain\ValueObjects;

final readonly class ApplicationDefinition
{
    /**
     * @param string $id
     * @param ReceiveDefinition[] $receives
     * @param array $sends
     */
    private function __construct(
        public string $id,
        public array $receives,
        public array $sends,
    )
    {

    }

    public static function new(
        string $id,
        array $receives,
        array $sends,
    ) {
        return new self($id, $receives, $sends);
    }
}