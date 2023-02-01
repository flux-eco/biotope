<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
interface NodeItemDefinition {
    public function getName(): string;
    public function getNodeItemDefinitions(object $nodeItem): array;
    public function hasNodeItemDefinitions(): bool;
}