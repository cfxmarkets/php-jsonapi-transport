<?php
namespace KS\JsonApi;

interface ServerRequestInterface extends \Psr\Http\Message\ServerRequestInterface {
    public function getRequestedResourceType(): string;
    public function getRequestedResourceId(): ?string;
    public function getRequestedRelationshipName(): ?string;
    public function getRequestedRelationshipId(): ?string;
    public function getEndpointName(): string;
    public function isForResourceCollection(): bool;
    public function isForPrimaryResource(): bool;
    public function isForRelationshipsCollection(): bool;
    public function isForSpecificRelationship(): bool;
    public function isForSpecificRelationshipMember(): bool;
}

