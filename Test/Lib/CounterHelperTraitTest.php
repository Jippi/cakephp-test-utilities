<?php
require_once dirname(dirname(dirname(__FILE__))) . '/Lib/CounterHelperTrait.php';

class CounterHelperTest extends PHPUnit_Framework_TestCase {

	use CounterHelperTrait;

	public function testNext() {
		$next = $this->next();
		$this->assertInstanceOf('PHPUnit_Framework_MockObject_Matcher_InvokedAtIndex', $next);
	}

	public function testCounters() {
		$this->Test = $this->getMock('CounterHelperTest', array('at'));
		$this->Test
			->staticExpects($this->any())
			->method('at')
			->will($this->returnCallback(function($input) {
				return $input;
			}));

		$this->assertSame(0, $this->Test->next());
		$this->assertSame(1, $this->Test->next());
		$this->assertSame(2, $this->Test->next());
		$this->assertSame(3, $this->Test->next());
		$this->assertSame(4, $this->Test->next());
		$this->assertSame(5, $this->Test->next());
	}

	public function testCountersNamed() {
		$this->Test = $this->getMock('CounterHelperTest', array('at'));
		$this->Test
			->staticExpects($this->any())
			->method('at')
			->will($this->returnCallback(function($input) {
				return $input;
			}));

		$this->assertSame(0, $this->Test->next());
		$this->assertSame(0, $this->Test->next('Foo'));
		$this->assertSame(0, $this->Test->next('Bar'));
		$this->assertSame(1, $this->Test->next('Foo'));
		$this->assertSame(1, $this->Test->next());
		$this->assertSame(2, $this->Test->next());
		$this->assertSame(3, $this->Test->next());
	}

	public function testCountersObjectNamed() {
		$this->Test = $this->getMock('CounterHelperTest', array('at'));
		$this->Test
			->staticExpects($this->any())
			->method('at')
			->will($this->returnCallback(function($input) {
				return $input;
			}));

		$this->assertSame(0, $this->Test->next());
		$this->assertSame(0, $this->Test->next($this->Test));
		$this->assertSame(0, $this->Test->next($this));
		$this->assertSame(1, $this->Test->next($this->Test));
		$this->assertSame(1, $this->Test->next());
		$this->assertSame(2, $this->Test->next());
		$this->assertSame(3, $this->Test->next());
	}

	public function testCountersDontPersist() {
		$next = $this->next();
		$this->assertSame('invoked at sequence index 0', $next->toString());
	}

/**
 * testCountersDontPersist2
 *
 * Verify that by default the internal state of the counters, does not persist
 * between tests
 *
 * @return void
 */
	public function testCountersDontPersist2() {
		$next = $this->next();
		$this->assertSame('invoked at sequence index 0', $next->toString());
	}
}
