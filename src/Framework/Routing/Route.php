<?php

namespace Framework\Routing;

class Route
{

	private $path;
	private $parameters;
	private $methods;

	public function __construct($path, array $parameters = [], array $methods = []){
		$this->path = $path;
		$this->parameters = $parameters;
		$this->methods = $methods;
	}

    public function getMethods(){
        $methods = $this->methods;
        if (in_array('GET', $methods) && !in_array('HEAD', $methods)) {
            $methods[] = 'HEAD';
        }
        
        return $methods;
    }

    private function getPattern(){
    	return '#^'.preg_quote($this->path).'$#';
    }

	private function executeRegexAgainst($path){
		if (!preg_match($this->getPattern(), $path, $matches)) {
			throw new \RuntimeException('Route does not match pattern.');
		}

		$this->parameters = array_merge($this->parameters, $matches);

		return $matches;
	}

	public function getParameters(){
		return $this->parameters;
	}
	
	public function match($path){
		try {
			$this->executeRegexAgainst($path);
		} catch (\Exception $e) {
			return false;
		}

		return true;
	}

	public function getPath(){
		return $this->path;
	}

}