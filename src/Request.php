<?php

class Request
{

	const GET     = 'GET';
	const POST    = 'POST';
	const PUT     = 'PUT';
	const PATCH   = 'PATCH';
	const OPTIONS = 'OPTIONS';
	const TRACE   = 'TRACE';
	const HEAD    = 'HEAD';
	const DELETE  = 'DELETE';
	const HTTP    = 'HTTP';
	const HTTPS   = 'HTTPS';

	private $method;
	private $scheme;
	private $schemeVersion;
	private $path;
	private $headers;
	private $body;

	public function __construct($method, $path, $scheme, $schemeVersion, array $headers = array(), $body = ''){
        $this->method        = $method;
        $this->path          = $path;
        $this->scheme        = $scheme;
        $this->schemeVersion = $schemeVersion;
        $this->headers       = $headers;
        $this->body          = $body;
	}

	public function getMethod(){
		return $this->method;
	}

	public function getPath(){
		return $this->path;	
	}

	public function getScheme(){
		return $this->scheme;
	}

	public function getSchemeVersion(){
		return $this->schemeVersion;
	}

	public function getHeaders(){
		return $this->headers;
	}

	public function getBody(){
		return $this->body;
	}
}
