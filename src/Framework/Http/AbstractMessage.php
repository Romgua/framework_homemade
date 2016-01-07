<?php

namespace Framework\Http;

abstract class AbstractMessage implements MessageInterface
{

	protected $scheme;
	protected $schemeVersion;
	protected $headers;
	protected $body;

	public function __construct($scheme, $schemeVersion, array $headers = array(), $body = ''){
		$this->setScheme($scheme);
        $this->setSchemeVersion($schemeVersion);
        $this->setHeaders($headers);
        $this->body = $body;
	}

	public function getBody(){
		return $this->body;
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

	public function getHeader($name){
		$name = strtolower($name);

		return isset($this->headers[$name]) ? $this->headers[$name] : null;
	}

	protected abstract function CreatePrologue();

	/**
	* Returns the Message instance as an HTTP string representation.
	*
	* @returns String
	*/
	final public function getMessage(){
		$message = $this->CreatePrologue();

		if(count($this->headers)) {
			$message .= PHP_EOL;
			foreach ($this->headers as $header => $value) {
				$message .= sprintf('%s: %s', $header, $value).PHP_EOL;
			}
		}

		$message .= PHP_EOL;
		if ($this->body) {
			$message .= $this->body;
		}

		return $message;
	}

	/**
	* String representation of a Messgae.
	* Alias of getMessage().
	*
	* @return String
	*/
	public function __toString(){
		return $this->getMessage();
	}

	protected static function parseBody($message){
        $pos = strpos($message, PHP_EOL.PHP_EOL);

        return (string) substr($message, $pos+2);
    }

    protected static function parseHeaders($message){
        $start = strpos($message, PHP_EOL) + 1;
        $end = strpos($message, PHP_EOL.PHP_EOL);
        $length = $end - $start;
        $lines = explode(PHP_EOL, substr($message, $start, $length));

        $i = 0;
        $headers = [];
        while (!empty($lines[$i])) {
            $line = $lines[$i];
            $result = preg_match('#^([a-z][a-z0-9-]+)\: (.+)$#i', $line, $header);
            if (!$result) {
                throw new MalformedHttpHeaderException(sprintf('Invalid header line at position %u: %s', $i+2, $line));
            }
            list(, $name, $value) = $header;

            $headers[$name] = $value;
            $i++;
        }

        return $headers;
    }

	private function setScheme($scheme){
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
	
	private function setSchemeVersion($version){
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

	/**
	* Adds a new normalized header value to the list of all headers.
	*
	* @param String $header The HTTP header name
	* @param String $value  The HTTP header value
	*
	* @throws \RuntimeException
	*/
	private function addHeader($header, $value){
		$header = strtolower($header);
			
		if (isset($this->headers[$header])) {
			throw new \RuntimeException(sprintf(
				'Header %s is already defined and cannot be set twice.',
				$header
			));
			
		}

		$this->headers[$header] = (string) $value;
	}

	private function setHeaders(array $headers){
		foreach ($headers as $header => $value) {
			$this->addHeader($header, $value);
		}
	}

}