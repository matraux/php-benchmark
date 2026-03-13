<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Test\Unit;

use Codeception\Configuration;
use JsonException;
use Matraux\PhpBenchmark\Measurement\Measurement;
use Matraux\PhpBenchmark\Test\Support\UnitTester;

final class MeasurementCest
{
	public function testProperties(UnitTester $tester): void
	{
		$measurement = new Measurement(
			label: 'Label',
			counter: 1,
			times: [0, 1.0, 2, 3.0, 4, 5.0],
			memory: 10,
		);

		$tester->assertEquals(2.5, $measurement->average);
		$tester->assertEquals(0.0, $measurement->min);
		$tester->assertEquals(5.0, $measurement->max);
		$tester->assertEquals(15.0, $measurement->total);
		$tester->assertEquals(6, $measurement->multiplier);
		$tester->assertEquals(1.7078, round($measurement->deviation, 4));

		$tester->assertEquals('Label', $measurement->label);
		$tester->assertEquals(1, $measurement->counter);
		$tester->assertEquals([0, 1.0, 2, 3.0, 4, 5.0], $measurement->times);
		$tester->assertEquals(10, $measurement->memory);
		$tester->assertEquals(null, $measurement->file);
		$tester->assertEquals(null, $measurement->line);
	}

	public function testJsonSerialize(UnitTester $tester): void
	{
		$measurement = new Measurement(
			label: 'Label',
			counter: 1,
			times: [0],
			memory: 0,
		);

		$json = json_encode($measurement) ?: throw new JsonException('Unable to encode json.');
		$file = Configuration::dataDir() . 'measurement.json';
		$tester->assertJsonStringEqualsJsonFile($file, $json);
	}

	public function testStringable(UnitTester $tester): void
	{
		$measurement = new Measurement(
			label: 'Label',
			counter: 1,
			times: [0],
			memory: 0,
		);

		$file = Configuration::dataDir() . 'measurement.txt';
		$text = (string) $measurement;
		$tester->assertStringEqualsFile($file, $text);
	}
}
