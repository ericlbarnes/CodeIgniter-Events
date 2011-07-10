<?php

define('BASEPATH', true); // allow script access
require '../libraries/events.php';
// var_dump(Events::has_listeners('non_existant'));

class eventsTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		Events::register('unit_test', array($this, 'callback'));
		Events::register('unit_test', array($this, 'callback2'));
	}

	public function callback()
	{
		return 'test';
	}

	public function callback2($var = '')
	{
		return $var;
	}

	public function test_has_listeners()
	{
		Events::register('unit_test', array($this, 'callback'));
		$this->assertFalse(Events::has_listeners('non_existant'));
		$this->assertTrue(Events::has_listeners('unit_test'));
	}

	public function test_single_callback()
	{
		Events::register('single', array($this, 'callback'));
		$this->assertEquals(Events::trigger('single', 'test'), 'test');
	}

	public function test_multiple_callback()
	{
		$this->assertEquals(Events::trigger('unit_test', 'test'), 'testtest2');
		$this->assertEquals(Events::trigger('unit_test', 'test2'), 'testtest2');
	}

	public function test_array_callback()
	{
		Events::register('test_array_callback', array($this, 'callback'));
		$arr = array('foo' => 'bar');
		$this->assertEquals(Events::trigger('test_array_callback', $arr), $this->callback($arr));
	}

}