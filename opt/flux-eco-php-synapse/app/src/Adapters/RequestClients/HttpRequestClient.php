<?php

namespace FluxEco\PhpSynapse\Adapters\RequestClients;

use FluxEco\PhpSynapse\Core\Domain\Http\HttpMessageBindingAttribute;
use FluxEco\PhpSynapse\Core\Domain\Messages\RequestMessage;
use FluxEco\PhpSynapse\Core\Domain\Messages\ResponseMessage;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\BindingDefinition;
use FluxEco\PhpSynapse\Core\Domain\ValueObjects\HttpBindingAttribute;

class HttpRequestClient implements RequestClient
{

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }

    public function request(string $address, object $parameters, BindingDefinition $bindingDefinition, RequestMessage $requestMessage): ResponseMessage
    {
        echo $this->generateUrl($address, $bindingDefinition->bindingAttributes, $parameters);
        $curl = curl_init($this->generateUrl($address, $bindingDefinition->bindingAttributes, $parameters));
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, HttpMessageBindingAttribute::METHOD->get($requestMessage->messageBinding));

        /*
        if (HttpRequestMessageAttribute::RAW_BODY->has($requestMessage)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, HttpRequestMessageAttribute::RAW_BODY->get($requestMessage));
        }*/
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: ' .HttpMessageBindingAttribute::CONTENT_TYPE->get($requestMessage->messageBinding)]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestMessage->content));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        echo $header;
        print_r( curl_error($curl)); exit;

        return json_decode($response);
    }

    private function generateUrl(string $address, object $bindingAttributes, object $parameters)
    {
        //if ((array)$parameters->count() > 0) {
            foreach ($parameters as $key => $value) {
                $address = $address . "/" . $key . "/" . $value;
            }
       //}

        print_r($bindingAttributes);

        return HttpBindingAttribute::PROTOCOL->get($bindingAttributes) . "://" . HttpBindingAttribute::HOST->get($bindingAttributes) . ":" . HttpBindingAttribute::PORT->get($bindingAttributes) ."/". $address;
    }
}