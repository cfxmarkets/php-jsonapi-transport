<?php
namespace CFX\JsonApi;

interface ServerRequestInterface extends \Psr\Http\Message\ServerRequestInterface {
    public function validateProtocol();
    public function parseBody(FactoryInterface $f);

    public function getRequestedResourceType();
    public function getRequestedResourceId();
    public function getEndpointName();
}

