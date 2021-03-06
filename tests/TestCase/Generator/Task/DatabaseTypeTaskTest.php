<?php

namespace IdeHelper\Test\TestCase\Generator\Task;

use Cake\Database\Type;
use Cake\TestSuite\TestCase;
use IdeHelper\Generator\Task\DatabaseTypeTask;
use TestApp\Database\Type\UuidType;

class DatabaseTypeTaskTest extends TestCase {

	/**
	 * @var \IdeHelper\Generator\Task\DatabaseTypeTask
	 */
	protected $task;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->task = new DatabaseTypeTask();
	}

	/**
	 * @return void
	 */
	public function testCollect() {
		Type::set('uuid', new UuidType());

		$result = $this->task->collect();

		$this->assertCount(1, $result);

		/** @var \IdeHelper\Generator\Directive\Override $directive */
		$directive = array_shift($result);
		$this->assertSame('\Cake\Database\Type::build(0)', $directive->toArray()['method']);

		$map = $directive->toArray()['map'];

		$expected = '\Cake\Database\Type\BinaryType::class';
		$this->assertSame($expected, (string)$map['binary']);

		$expected = '\TestApp\Database\Type\UuidType::class';
		$this->assertSame($expected, (string)$map['uuid']);
	}

}
