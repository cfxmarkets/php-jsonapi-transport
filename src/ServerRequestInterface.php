<?php
namespace KS\JsonApi;

interface ServerRequestInterface extends \Psr\Http\Message\ServerRequestInterface {
    public function getRequestedResourceType();
    public function getRequestedResourceId();
    public function getRequestedRelationshipName();
    public function getRequestedRelationshipId();
    public function getEndpointName();
    public function isForResourceCollection();
    public function isForPrimaryResource();
    public function isForRelationshipsCollection();
    public function isForSpecificRelationship();
    public function isForSpecificRelationshipMember();
}

