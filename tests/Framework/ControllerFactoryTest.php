<?php

namespace tests\Framework;

use Framework\ControllerFactory;

class ControllerFactoryTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @expectedException \RuntimeException
	 */
	public function testCreateClassDoesNotExist(){
		$factory = new ControllerFactory();

		$factory->createController([ '_controller' => 'F0000000000000']);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testCreateNameIsNotDefined(){
		$factory = new ControllerFactory();

		$factory->createController([ 'foo' => 'bar']);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testCreateNotInvokableController(){
		$factory = new ControllerFactory();

		$this->assertInstanceOf('stdClass', $factory->createController([ '_controller' => 'stdClass' ]));
	}

	public function testCreateController(){
		$factory = new ControllerFactory();

		$this->assertInstanceOf(Foobar::class, $factory->createController([ '_controller' => Foobar::class ]));
	}

}

class Foobar
{
	public function __invoke(){

	}
}