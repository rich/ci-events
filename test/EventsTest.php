<?php
require_once 'test_support.php';

class EventsTest extends PHPUnit_Framework_TestCase {	
	function setUp() {
		$this->events =& new Events;
	}

	public function testPushAndPop() {
		$this->events->append('thing.created', array());
		print_r($this->events);
		$stack = array();
		$this->assertEquals(0, count($stack));

		array_push($stack, 'foo');
		$this->assertEquals('foo', $stack[count($stack)-1]);
		$this->assertEquals(1, count($stack));

		$this->assertEquals('foo', array_pop($stack));
		$this->assertEquals(0, count($stack));
	}
}
?>