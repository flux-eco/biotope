<?php

namespace FluxEco\PhpSynapse\Core\Domain\Messages;


use FluxEco\PhpSynapse\Core\Domain\Bindings\MessageBinding;
use FluxEco\PhpSynapse\Core\Domain\Mappings\Mappings;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\LocationName;
use WeakMap;

final readonly  class RequestMessage
{
    private function __construct(
        public WeakMap $messageBinding,
        public MessageHeader  $header,
        public object         $content
    )
    {

    }

    public static function new(
        MessageHeader  $header,
        object         $content
    ): self
    {
        return new self(...get_defined_vars());
    }

    public static function fromMappings(
        Mappings $mappings,
        object $payload
    ) {
        $mappedData = $mappings->getMappedData(LocationName::PAYLOAD, $payload);

        return new self();
    }

    public function newRequestMessage(object $payload): RequestMessage
    {


        $messageBinding = new WeakMap();

        match ($this->type) {
            BindingType::HTTP =>
            [$messageBinding->offsetSet(
                Http\HttpMessageBindingAttribute::CONTENT_TYPE, Http\ContentType::APPLICATION_JSON->value),
                $messageBinding->offsetSet(
                    Http\HttpMessageBindingAttribute::METHOD, HTTP\Method::GET->value)]
        };

        return RequestMessage::new(
            $messageBinding,
            MessageHeader::new(),
            new stdClass(),
        );

        //  Http\Method::from($mappedData->offsetGet(Http\HttpBindingAttribute::METHOD->value)
        //Http\ContentType::from($mappedData->offsetGet(Http\HttpBindingAttribute::CONTENT_TYPE->value))
    }

    public function newResponseMessage(object $response): ResponseMessage
    {
        $mappedData = $this->responseMappings->getMappedData(LocationName::RESPONSE, $response);
        return match ($this->type) {
            BindingType::HTTP => ResponseMessage::new(
                $mappedData->offsetGet('header'),
                $mappedData->offsetGet('content'),
            )
        };
    }
}