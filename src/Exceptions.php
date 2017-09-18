<?php
namespace KS\JsonApi;

class ProtocolException extends \RuntimeException { }
class BadAcceptException extends ProtocolException { }
class BadContentTypeException extends ProtocolException { }
class BadUriException extends ProtocolException { }

