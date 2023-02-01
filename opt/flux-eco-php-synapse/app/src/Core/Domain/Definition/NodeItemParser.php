<?php

namespace FluxEco\PhpSynapse\Core\Domain\Definition;
final class NodeItemParser
{

    private function __construct(
        public array   $nodeItems,
        private string $mainDocumentDirectoryPath,
        private array  $loadedDocuments = []
    )
    {

    }

    public static function new(string $mainDocumentDirectoryPath): self
    {
        return new self([], $mainDocumentDirectoryPath);
    }

    public function parseMainDocument(object $node)
    {
        $documentId = "";
        $this->parseNode($documentId, "#", $node);
        $this->dereference();
    }

    private function parseNode(string $documentId, string $path, object $node): void
    {
        foreach ($node as $propertyKey => $propertyValue) {
            $this->parseNodeItem($documentId, $path, $node, $propertyKey);
        }
    }

    private function parseNodeItem(string $documentId, string $path, object $node, string $propertyKey): void
    {
        $nodeItem = $node->{$propertyKey};
        $nodeItemPath = $path . "/" . $propertyKey;

        if ($this->nodeItemIsNull($nodeItem)) {
            return;
        }

        if (is_object($nodeItem) === false && $propertyKey !== '$ref') {
            $this->append($nodeItemPath, $nodeItem);
            return;
        }

        if (is_object($nodeItem)) {
            $nodeItem = $this->appendDocumentIdsToReferences($documentId, $path, $nodeItem);
            if (property_exists($nodeItem, '$ref',)) {
                if (str_starts_with($nodeItem->{'$ref'}, "#") === false) {
                    $this->loadExternalDocument($nodeItem->{'$ref'});
                }
            }
        }
        $this->append($nodeItemPath, $nodeItem);
        if (is_object($nodeItem)) {
            $this->parseNode($documentId, $nodeItemPath, $nodeItem);
        }
    }

    private function dereference(): void
    {
        foreach ($this->nodeItems as $path => $nodeItem) {
            $nodeItem = $this->dereferenceNodeItem($path, $nodeItem);
            $this->append($path, $nodeItem);
        }
    }

    private function dereferenceNodeItem(string $path, mixed $nodeItem): mixed
    {
        if (is_object($nodeItem)) {
            foreach ($nodeItem as $propertyKey => $propertyValue) {
                $propertyPath = $path . "/" . $propertyKey;
                if (is_object($propertyValue) === false) {
                    continue;
                }
                if(property_exists($propertyValue, '$ref') && $this->nodeItemIsLoaded($propertyValue->{'$ref'})) {
                    $propertyValue = $this->getLoadedNodeItem($propertyValue->{'$ref'});
                    $this->append($propertyPath, $propertyValue);
                    $nodeItem->{$propertyKey} = $propertyValue;
                }
                $nodeItem->{$propertyKey} = $this->dereferenceNodeItem($propertyPath, $propertyValue);
            }
        }
        return $nodeItem;
    }

    private function append($path, mixed $nodeItem)
    {
        $this->nodeItems[$path] = $nodeItem;
    }

    public function nodeItemIsNull(mixed $nodeItem): bool
    {
        return is_null($nodeItem);
    }


    public function appendDocumentIdsToReferences(string $documentId, string $path, object $nodeItem): object
    {
        if (property_exists($nodeItem, '$ref') === true) {
            if (empty($documentId)) {
                return $nodeItem;
            }
            if (str_starts_with($nodeItem->{'$ref'}, "#")) {
                $nodeItem->{'$ref'} = $documentId . $nodeItem->{'$ref'};
                return $nodeItem;
            }
        }
        foreach ($nodeItem as $propertyKey => $propertyValue) {
            if (is_object($propertyValue)) {
                $nodeItem->{$propertyKey} = $this->appendDocumentIdsToReferences($documentId, $path . "/" . $propertyKey, $propertyValue);
            }
        }
        return $nodeItem;
    }

    public function loadExternalDocument(string $referencePath): void
    {
        $referencePath = explode("#", $referencePath);
        $externalDocumentId = $referencePath[0];
        if (in_array($externalDocumentId, $this->loadedDocuments)) {
            return;
        }
        $this->loadedDocuments[] = $externalDocumentId;
        $node = json_decode(file_get_contents($this->mainDocumentDirectoryPath . "/" . $externalDocumentId));
        $this->parseNode($externalDocumentId, $externalDocumentId . "#", $node);
    }

    public function nodeItemIsLoaded(string $nodeItemPath): bool
    {
        return array_key_exists($nodeItemPath, $this->nodeItems);
    }

    public function getLoadedNodeItem(string $referencePath): mixed
    {
        return $this->nodeItems[$referencePath];
    }

    public function nodeItemIsExternalReference(string $documentId, string $referencePath): bool
    {
        if (str_starts_with($referencePath, "#") === true) {
            return false;
        }
        return true;
    }


}