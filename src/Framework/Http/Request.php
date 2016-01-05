<?php

namespace Framework\Http;

class Request
{

	const GET     = 'GET';
	const POST    = 'POST';
	const PUT     = 'PUT';
	const PATCH   = 'PATCH';
	const OPTIONS = 'OPTIONS';
	const CONNECT = 'CONNECT';
	const TRACE   = 'TRACE';
	const HEAD    = 'HEAD';
	const DELETE  = 'DELETE';

	const HTTP    = 'HTTP';
	const HTTPS   = 'HTTPS';

	const VERSION_1_0 = '1.0';
	const VERSION_1_1 = '1.1';
	const VERSION_2_0 = '2.0';

	private $method;
	private $scheme;
	private $schemeVersion;
	private $path;
	private $headers;
	private $body;

	public function __construct($method, $path, $scheme, $schemeVersion, array $headers = array(), $body = ''){
        $this->setMethod($method);
        $this->path          = $path;
        $this->setScheme($scheme);
        $this->setSchemeVersion($schemeVersion);
        $this->headers       = $headers;
        $this->body          = $body;
	}

	public function getMethod(){
		return $this->method;
	}

	private function setMethod($method){
		$methods = [
			self::GET,
			self::POST,
			self::PUT,
			self::PATCH,
			self::OPTIONS,
			self::CONNECT,
			self::TRACE,
			self::HEAD,
			self::DELETE,
		];

		if (!in_array($method, $methods)) {
			throw new \InvalidArgumentException(sprintf(
				"Method %s is not supported and must be one of %s.",
				$method,
				implode(', ', $methods)
			));
		}

		$this->method = $method;
	}

	public function getPath(){
		return $this->path;	
	}

	public function getScheme(){
		return $this->scheme;
	}

	public function setScheme($scheme){
		$schemes = [
			self::HTTP,
			self::HTTPS,
		];

		if (!in_array($scheme, $schemes)) {
			throw new \InvalidArgumentException(sprintf(
				"Scheme %s is not supported and must be one of %s.",
				$scheme,
				implode(', ', $schemes)
			));
		}

		$this->scheme = $scheme;
	}

	public function getSchemeVersion(){
		return $this->schemeVersion;
	}

	public function setSchemeVersion($version){
		$versions = [
			self::VERSION_1_0,
			self::VERSION_1_1,
			self::VERSION_2_0,
		];

		if (!in_array($version, $versions)) {
			throw new \InvalidArgumentException(sprintf(
				"Scheme %s is not supported and must be one of %s.",
				$version,
				implode(', ', $versions)
			));
		}

		$this->schemeVersion = $version;
	}

	public function getHeaders(){
		return $this->headers;
	}

	public function getBody(){
		return $this->body;
	}

}
