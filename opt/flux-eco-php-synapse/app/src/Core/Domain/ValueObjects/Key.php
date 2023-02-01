<?php

namespace FluxEco\PhpSynapse\Core\Domain\ValueObjects;

final readonly  class Key {
    private function __construct(
        public string $name
    ) {

    }

    public static function new() {

    }

}