<?php
namespace CFX\JsonApi;

trait MessageTrait {
    public function withBody(\Psr\Http\Message\StreamInterface $body) {
        $body = JsonApiStream::fromStream($body);
        return parent::withBody($body);
    }

    public function withHeader($name, $value) {
        if (strtolower($name) == 'content-type' && strpos($value, 'application/vnd.api+json') === false) throw new BadContentTypeException("Content type must be specified as `application/vnd.api+json` for JsonApi Responses");
        return parent::withHeader($name, $value);
    }
}


