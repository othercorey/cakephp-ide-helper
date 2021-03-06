<?php

namespace IdeHelper\Test\TestCase\Generator\Task;

use IdeHelper\Generator\Task\ValidationTask;
use Shim\TestSuite\TestCase;

class ValidationTaskTest extends TestCase {

	/**
	 * @var \IdeHelper\Generator\Task\ValidationTask
	 */
	protected $task;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->task = new ValidationTask();
	}

	/**
	 * @return void
	 */
	public function testCollect() {
		$result = $this->task->collect();

		$this->assertCount(1, $result);

		/** @var \IdeHelper\Generator\Directive\Override $directive */
		$directive = array_shift($result);
		$this->assertSame('\Cake\Validation\Validator::requirePresence()', $directive->toArray()['method']);

		$map = $directive->toArray()['list'];
		$expected = [
			"'create'",
			"'update'",
		];
		$this->assertSame($expected, $map);
	}

}
