<?php
namespace KS\JsonApi;

interface ResponseInterface extends \Psr\Http\Message\ResponseInterface {
    public function getJsonApiDoc(): DocumentInterface;
    public function withJsonApiDoc(DocumentInterface $doc=null): ResponseInterface;
}

