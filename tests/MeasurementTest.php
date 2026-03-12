<?php declare(strict_types=1);

namespace Matraux\PhpBenchmarkTest;

use Matraux\PhpBenchmark\Measurement\Measurement;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/Bootstrap.php';

Bootstrap::tester();

/**
 * @testCase
 */
final class MeasurementTest extends TestCase
{
	public function testProperties(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		$measurement = Measurement::create(
			label: 'Label',
			counter: 1,
			times: [0, 1.0, 2, 3.0, 4, 5.0],
			memory: 10,
		);

		Assert::equal($measurement->average, 2.5);
		Assert::equal($measurement->min, 0.0);
		Assert::equal($measurement->max, 5.0);
		Assert::equal($measurement->total, 15.0);
		Assert::equal($measurement->multiplier, 6);
		Assert::equal(round($measurement->deviation, 4), 1.7078);

		Assert::equal($measurement->label, 'Label');
		Assert::equal($measurement->counter, 1);
		Assert::equal($measurement->times, [0, 1.0, 2, 3.0, 4, 5.0]);
		Assert::equal($measurement->memory, 10);
		Assert::equal($measurement->file, null);
		Assert::equal($measurement->line, null);
	}

	public function testJsonSerialize(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		$measurement = Measurement::create(
			label: 'Label',
			counter: 1,
			times: [0],
			memory: 0,
		);

		Assert::noError(function () use ($measurement): void {
			json_encode($measurement);
		});
	}

	public function testStringable(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		$measurement = Measurement::create(
			label: 'Label',
			counter: 1,
			times: [0],
			memory: 0,
		);

		Assert::noError(function () use ($measurement): void {
			(string) $measurement;
		});
	}
}

new MeasurementTest()->run();
