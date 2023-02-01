<?php

namespace FluxEco\PhpSynapse\Core\Domain\Channel;

final readonly class ChannelAdress {
    private function __construct(public string $path, public object $parameters) {

    }

    public static function new(string $path, object $parameters): self {
        return new self(...get_defined_vars());
    }

    public static function fromRef(string $pointer): self {
        return new self(...get_defined_vars());
    }
}