<?php
namespace KS\JsonApi;

trait ServerRequestTrait {
    protected $requestedResourceType;
    protected $requestedResourceId;
    protected $handlesRelationships = false;
    protected $requestedRelationshipName;
    protected $requestedRelationshipId;

    protected static $pathFormat = '/[resource](/[id](/relationships(/[relationshipName](/[relationshipId]))))';
    protected static $endpointProps = ['requestedResourceType','requestedResourceId','handlesRelationships','requestedRelationshipName', 'requestedRelationshipId'];

    protected function validateProtocol() {
        if (!$this->getHeader('Accept') || !in_array('application/vnd.api+json', $this->getHeader('Accept'))) throw new BadAcceptException("Your request must specify that it accepts content of type `application/vnd.api+json` through the `Accept` header.");
        if (in_array($this->getMethod(), ["POST", "PUT", "PATCH"]) && (!$this->getHeader('Content-Type') || !in_array('application/vnd.api+json', $this->getHeader('Content-Type')))) throw new BadContentTypeException("Your request must specify that it is sending content of type `application/vnd.api+json` through the `Content-Type` header");

        // Must have a resource type
        if (!$this->requestedResourceType) throw new BadUriException("Arguments passed to this API should conform to the following format: `".static::$pathFormat."`. You've passed `{$this->getUri()->getPath()}`.");

        // Must specify relationship requests correctly
        if ($this->handlesRelationships && $this->handlesRelationships != 'relationships') throw new BadUriException("Arguments passed to this API should conform to the following format: `".static::$pathFormat."`. You've passed `{$this->getUri()->getPath()}`.");
        else $this->handlesRelationships = (bool)$this->handlesRelationships;
    }

    protected function parsePath(array $path) {
        for ($i = 0; $i < count(static::$endpointProps) && count($path) > 0; $i++) $this->{static::$endpointProps[$i]} = array_shift($path);

        // Must not have extra params
        if (count($path) > 0) throw new ProtocolException("Arguments passed to this API should conform to the following format: `".static::$pathFormat."`. You've passed `{$this->getUri()->getPath()}`.");

        return $path;
    }

    public function getRequestedResourceType() { return $this->requestedResourceType; }
    public function getRequestedResourceId() { return $this->requestedResourceId; }
    public function getRequestedRelationshipName() { return $this->requestedRelationshipName; }
    public function getRequestedRelationshipId() { return $this->requestedRelationshipId; }
    public function getEndpointName() {
        $path = [];
        foreach(static::$endpointProps as $p) {
            if (!$p) break;
            if ($p == 'handlesRelationships') $p = 'relationships';
            $path[] = $p;
        }
        return $this->getMethod()." /".implode("/", $path);
    }

    public function isForResourceCollection() { return $this->requestedResourceId == null; }
    public function isForPrimaryResource() { return $this->requestedResourceId !== null && $this->handlesRelationships == false; }
    public function isForRelationshipsCollection() { return $this->handlesRelationships && !$this->requestedRelationshipName; }
    public function isForSpecificRelationship() { return $this->requestedRelationshipName !== null; }
    public function isForSpecificRelationshipMember() { return $this->requestedRelationshipId !== null; }
}


