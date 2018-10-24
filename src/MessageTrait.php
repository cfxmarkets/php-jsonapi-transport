<?php
namespace CFX\JsonApi;

trait MessageTrait {
    protected $jsonApiDoc;

    public function getJsonApiDoc() { return $this->jsonApiDoc; }
    public function withJsonApiDoc(DocumentInterface $doc=null) {
        if ($doc === $this->jsonApiDoc) return $this;

        $new = clone $this;
        $new->jsonApiDoc = $doc;

        if ($doc) {
            if (strpos($new->getHeaderLine('Content-Type'), 'application/vnd.api+json') === false) return $new->withHeader('Content-Type', 'application/vnd.api+json; charset=utf-8');
            else return $new;
        } else {
            return $new->withoutHeader('Content-Type');
        }
    }

    public function getBody() {
        if ($this->jsonApiDoc) {
            $str = json_encode($this->jsonApiDoc);
            $err = json_last_error();
            if ($err > 0) {
                switch ($err) {
                case JSON_ERROR_NONE:
                    $err = 'No errors';
                    break;
                case JSON_ERROR_DEPTH:
                    $err = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $err = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $err = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $err = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $err = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $err = 'Unknown error';
                    break;
                }
                throw new \RuntimeException("Error json-encoding JSONAPI Doc: $err");
            }
            return \GuzzleHttp\Psr7\stream_for($str);
        } else {
            return parent::getBody();
        }
	}

    public function withBody(\Psr\Http\Message\StreamInterface $body) {
        throw new \RuntimeException("The `withBody` method shouldn't be used. You should instead use the `withJsonApiDoc` method to load a body into a JsonApi Response.");
    }

    public function withHeader($name, $value) {
        if (strtolower($name) == 'content-type' && strpos($value, 'application/vnd.api+json') === false) throw new BadContentTypeException("Content type must be specified as `application/vnd.api+json` for JsonApi Responses");
        return parent::withHeader($name, $value);
    }
}

