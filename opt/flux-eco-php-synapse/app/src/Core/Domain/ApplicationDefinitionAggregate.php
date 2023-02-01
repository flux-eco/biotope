<?php

namespace FluxEco\PhpSynapse\Core\Domain;

use FluxEco\PhpSynapse\Adapters\Definition\DefinitionRepository;
use FluxEco\PhpSynapse\Core\Domain\Definition\BindingType;
use FluxEco\PhpSynapse\Core\Domain\Definition\DefinitionId;
use FluxEco\PhpSynapse\Core\Domain\Definition\DefinitionItemId;
use FluxEco\PhpSynapse\Core\Domain\Definition\NodeItemParser;
use FluxEco\PhpSynapse\Core\Domain\Definition\RequestChannel;
use FluxEco\PhpSynapse\Core\Domain\Definition\TechnologyType;

class ApplicationDefinitionAggregate
{


    /**
     * @param string $name
     */
    private function __construct(
        private Definition\DefinitionId $mainDefinitionId,
        private string                  $mainDefinitionDocumentDirectoryPath
    )
    {

    }

    public static function new(
        Definition\DefinitionId $mainDefinitionId,
    )
    {
        $obj = new self(
            $mainDefinitionId,
            pathinfo($mainDefinitionId->definitionDocumentFilePath, PATHINFO_DIRNAME)
        );


        // $obj->loadDefinitions();

        return $obj;
    }

    private function loadDefinitions()
    {

    }

    private function loadDefinitionDocument(string $definitionDocumentPath, string $documentNode): void
    {

       /* if ($this->isDefinitionDocumentLoaded($definitionDocumentPath) === true) {
            return;
        }
        $node = json_decode(file_get_contents($definitionDocumentPath));

        $nodeItemParser = NodeItemParser::new(pathinfo($definitionDocumentPath, PATHINFO_DIRNAME));
        $nodeItemParser->parseMainDocument($node);
        $this->loadedDefinitionDocuments = $nodeItemParser->nodeItems;
        print_r($this->loadedDefinitionDocuments);*/
    }


    private function appendDocumentToReferences()
    {
        foreach ($this->applicationDefinitions as $itemReference => $itemValue) {
            if (is_object($itemValue) && property_exists($itemValue, '$ref')) {
                if (str_starts_with($itemValue->{'$ref'}, "#") === true && str_starts_with($itemReference, "#") === false) {
                    $referenceParts = explode("#", $itemReference);
                    $nodeRefParts = explode("#", $itemValue->{'$ref'});
                    $itemValue->{'$ref'} = $referenceParts[0] . "#" . $nodeRefParts[1];
                    $this->applyDefinitionItemLoaded($itemReference, $this->getDefinitionItem($itemValue->{'$ref'}));
                }
            }
        }
    }


    private function applyDefinitionDocumentLoaded(string $definitionDocumentPath, string $applicationId): void
    {
        $this->loadedDefinitionDocuments[$definitionDocumentPath] = $applicationId;
    }

    private function isDefinitionDocumentLoaded(string $definitionDocumentPath): bool
    {
        return array_key_exists($definitionDocumentPath, $this->loadedDefinitionDocuments);
    }

    /**
     * @param string $nodeRef
     * @param object $node
     * @param array $propertyKeys
     * @return void
     */
    private function loadDefinition(string $nodeRef, object $node, array $propertyKeys): void
    {
        $repository = DefinitionRepository::new($this->mainDefinitionId->definitionId,$this->mainDefinitionDocumentDirectoryPath, $this->mainDefinitionDocumentDirectoryPath . "/../ schemas");
        print_r($repository->getNodeItems($this->mainDefinitionId->definitionId));
        exit;
/*
        foreach ($propertyKeys as $key) {

            if ($nodeItemParser->nodeItemIsNull() === false) {
                $this->applyDefinitionItemLoaded($nodeItemParser->nodeItemRef, $nodeItemParser->nodeItem);
            }

            if ($nodeItemParser->nodeItemIsExternalReference() === true) {
                $this->loadDefinitionDocument($nodeItemParser->getDocumentFilePath($this->mainDefinitionId->definitionDocumentFilePath), $nodeItemParser->getDocumentReference($nodeRef));
                //dereference
                if ($this->isDefinitionItemLoaded($nodeItemParser->nodeItem->{'$ref'})) {
                    $this->applyDefinitionItemLoaded($nodeItemParser->nodeItemRef, $this->getDefinitionItem($nodeItemParser->nodeItem->{'$ref'}));
                }
            }

            //append document node-path
            if ($nodeItemParser->nodeItemIsReference() === true) {
                $ref = $nodeItemParser->nodeItem->{'$ref'};

                if (str_starts_with($nodeItemParser->nodeItem->{'$ref'}, "#") === true && str_starts_with($nodeItemParser->nodeItemRef, "#") === false) {
                    $refParts = explode("#", $nodeItemParser->nodeItemRef);
                    $ref = $refParts[0] . $nodeItemParser->nodeItem->{'$ref'};
                }

                if ($this->isDefinitionItemLoaded($ref) === true) {
                    $this->applyDefinitionItemLoaded($nodeItemParser->nodeItemRef, $this->getDefinitionItem($ref));
                }
            }

            if ($nodeItemParser->parseChilds() === true) {
                $this->loadDefinition($nodeItemParser->nodeItemRef, $nodeItemParser->nodeItem, $nodeItemParser->getChildNodesDefinitions());
            } else {
                echo $nodeItemParser->nodeItemRef;
                echo PHP_EOL;
            }


        }*/
    }

    private function isDefinitionItemLoaded(string $reference): bool
    {
        return array_key_exists($reference, $this->applicationDefinitions);
    }


    private function applyDefinitionItemLoaded(string $nodeItemRef, $item): void
    {
        $this->applicationDefinitions[$nodeItemRef] = $item;
    }


    private function getDefinitionItem(string $itemReference): mixed
    {
        return $this->applicationDefinitions[$itemReference];
    }


    public function requestChannelBindingTypeExists(string $operationName, Definition\BindingType $bindingType): bool
    {
return false;
        $nodeItemReference = RequestChannel::RECEIVER->getReceiverReference("#", $operationName, $bindingType);
        return $this->isDefinitionItemLoaded($nodeItemReference);
    }

    public function getRequestChannelHttpUrl(string $operationName): string
    {
        $repository = DefinitionRepository::new($this->mainDefinitionId,$this->mainDefinitionDocumentDirectoryPath, $this->mainDefinitionDocumentDirectoryPath . "/../ schemas");
        ///print_r($repository->getNodeItems($this->mainDefinitionId));

        print_r($repository->getNodeItem(DefinitionItemId::new($this->mainDefinitionId, "#/channels/requests/getUser")));
        exit;

       // $nodeItemReference = RequestChannel::RECEIVER->getReceiverReference("#", $operationName, BindingType::HTTP);
       // $receiver = $this->getDefinitionItem($nodeItemReference);

       // print_r($receiver);
        exit;


        //todo
        /*if (property_exists($server, '$ref')) {
            $server = $this->applicationDefinitions[$server->{'$ref'}];
        }*/


    }

}