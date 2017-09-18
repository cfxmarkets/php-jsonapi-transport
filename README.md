JSON-API Transport
=================================================================

*A class that provides a PHP implementation of JSON API transport objects. Note, while this includes an implementation of JsonApi objects as a dependency, it focuses specifically on classes that implement the *transport protocol* defined in the [json-api spec](http://jsonapi.org/format/).*

## Overview

This package focuses on implementing Request and Response classes that make it easier to validate incoming and outgoing JSON-API messages. It defines interfaces that extend `PSR-7`, a set of traits that may be used to implement these extensions, and a set of concrete classes extended from [Guzzle's PSR-7 implementation](https://github.com/guzzle/psr7).

## Usage

Most of the time, this will be used to receive requests from an API client. To do this, you'll create a `ServerRequest` object, then add the incoming JsonApi document using `withJsonApiDoc`. (**Note:** Guzzle's original implementation doesn't support use of the `ServerRequest::fromGlobals` method to instantiate derivative objects. To use this, you'll have to use a modified implementation, such as my fork at https://github.com/kael-shipman/psr7. See the discussion [here](https://github.com/guzzle/psr7/pull/158).

