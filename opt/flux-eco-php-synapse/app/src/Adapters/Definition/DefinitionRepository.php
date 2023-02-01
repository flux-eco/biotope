<?php

namespace FluxEco\PhpSynapse\Adapters\Definition;

use FluxEco\PhpSynapse\Adapters\Outbounds\DefinitionItemAdapter;
use FluxEco\PhpSynapse\Core\Domain\Definition;
use FluxEco\PhpSynapse\Core\Ports;
use WeakMap;

final class DefinitionRepository implements Ports\DefinitionRepository
{

    private function __construct(public Definition\DefinitionId $mainDefinitionId, private string $definitionDocumentsPath, private string $schemaDirectoryPath, private WeakMap $storage)
    {

    }

    public static function new(Definition\DefinitionId $mainDefinitionId, string $definitionDocumentsPath, string $schemaDirectoryPath): DefinitionRepository
    {
        return new self($mainDefinitionId, $definitionDocumentsPath, $schemaDirectoryPath, new WeakMap());
    }

    public function getInformationNode(Definition\DefinitionId $definitionId): Definition\Info
    {
        return $this->storage[$definitionId] ??= $this->loadInformationNode($definitionId);
    }

    private function loadInformationNode(Definition\DefinitionId $definitionId): Definition\Info
    {
        $definitionDocument = $this->getDefinitionDocument($definitionId);
        return DefinitionItemAdapter::new($this->schemaDirectoryPath)->toDefinitionItem($definitionDocument, Definition\DefinitionItemType::INFO);
    }


    private function getDefinitionItemTypeItems(Definition\DefinitionItemType $definitionItemType): array
    {

    }


    public function getNodeItems(Definition\DefinitionId $definitionId): array
    {
        return $this->storage[$definitionId] ??= $this->loadNodeItems($definitionId, $this->getDefinitionDocument($definitionId)->definitionNode, "#", "");
    }

    private function loadNodeItems($definitionId, object $nodeItem, string $currentPath, string $currentKey): array
    {
        $nodeItems = [];

        if(is_object($nodeItem)) {
            foreach ($nodeItem as $currentNodeKey => $propertyValue) {
                $itemPath = $currentPath . "/" . $currentNodeKey;
                if(is_object($propertyValue)) {
                    $nodeItems = array_merge($nodeItems, $this->loadNodeItems($definitionId, $propertyValue, $itemPath, $currentNodeKey));
                    $nodeItems[$itemPath] = $propertyValue;
                } else {
                    $nodeItems[$itemPath] = $propertyValue;
                }
            }
            if(property_exists($nodeItem,'$ref')) {
                if (str_starts_with($nodeItem->{'$ref'}, "#") === false) {
                    $referencePath = explode("#", $nodeItem->{'$ref'});
                    $additionalDefinitionId = $referencePath[0];
                    $additionalDocumentDefinitionId = Definition\DefinitionId::new($additionalDefinitionId, $this->definitionDocumentsPath . "/" . $additionalDefinitionId, $additionalDefinitionId."#");
                    $this->loadDefinitionDocument($additionalDocumentDefinitionId);
                    //$nodeItems[$currentPath] = $this->getNodeItem(Definition\DefinitionItemId::new($additionalDocumentDefinitionId, $nodeItem->{'$ref'}));
                }
            }
        }

        return $nodeItems;
    }

    public function getNodeItem(Definition\DefinitionItemId $definitionItemId): mixed
    {
        return $this->storage[$definitionItemId] ??= $this->loadNodeItem($definitionItemId);
    }

    private function loadNodeItem(Definition\DefinitionItemId $definitionItemId): ?object
    {
        $nodeItems =  $this->getNodeItems($definitionItemId->definitionId);

        if(array_key_exists($definitionItemId->path, $nodeItems)) {
            return $nodeItems[$definitionItemId->path];
        }
        return null;
    }


    public function getDefinitionItemTypeSchema(Definition\DefinitionItemType $definitionItemType): object
    {
        return $this->storage[$definitionItemType] ??= $this->loadDefinitionItemTypeSchema($definitionItemType);
    }

    public function loadDefinitionItemTypeSchema(Definition\DefinitionItemType $definitionItemType): object
    {
        return json_decode(file_get_contents($this->schemaDirectoryPath . "/" . $definitionItemType->value . ".json"));
    }


    private function getDefinitionDocument(Definition\DefinitionId $definitionId): Definition\DefinitionDocument
    {
        return $this->storage[$definitionId] ??= $this->loadDefinitionDocument($definitionId);
    }

    private function loadDefinitionDocument(Definition\DefinitionId $id): Definition\DefinitionDocument
    {
        return Definition\DefinitionDocument::new($id->definitionId, json_decode(file_get_contents($this->definitionDocumentsPath ."/".$id->definitionId)));
    }


    public function getBinding(Definition\BindingType $bindingType): Definition\HttpBinding|Definition\PhpApiBinding|Definition\CliBinding
    {
        // TODO: Implement getBinding() method.
    }

    public function getOperation(Definition\OperationType $operationType, string $operationName): Definition\ReceiveOperation|Definition\RequestOperation|Definition\SendOperation
    {
        // TODO: Implement getOperation() method.
    }

    public function getChannel(Definition\ChannelType $channelType, string $channelPath): Definition\ReceiveChannel|Definition\RequestChannel|Definition\SendChannel
    {
        // TODO: Implement getChannel() method.
    }


    public function getDefaultValue(string $defaultValueName): Definition\Schema
    {
        // TODO: Implement getDefaultValue() method.
    }

    public function getSchema(string $schemaName): Definition\Schema
    {

    }
}