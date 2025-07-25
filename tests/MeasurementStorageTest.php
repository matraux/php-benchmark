<?php declare(strict_types = 1);

namespace Matraux\PhpBenchmarkTest;

use LogicException;
use Matraux\PhpBenchmark\Measurement\Measurement;
use Matraux\PhpBenchmark\Measurement\MeasurementStorage;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/Bootstrap.php';

Bootstrap::tester();

/**
 * @testCase
 */
final class MeasurementStorageTest extends TestCase
{

	public function testSingleton(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		$a = MeasurementStorage::create();
		$b = MeasurementStorage::create();

		Assert::equal($a, $b);
	}

	public function testAdd(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		$measurement = Measurement::create('', 0, [0], 0);

		Assert::noError(function () use ($measurement): void {
			MeasurementStorage::add($measurement);
			MeasurementStorage::add($measurement);
		});
	}

	public function testCountable(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		$storage = MeasurementStorage::create();

		Assert::count(0, $storage);
	}

	public function testIterator(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		Assert::noError(function (): void {
			foreach (MeasurementStorage::create() as $measurement) {

			}
		});

		Assert::noError(function (): void {
			iterator_to_array(MeasurementStorage::create());
		});
	}

	public function testClone(): void
	{
		Bootstrap::purgeTemp(__FUNCTION__);

		Assert::error(function (): void {
			$clone = clone MeasurementStorage::create();
		}, LogicException::class);
	}

}

new MeasurementStorageTest()->run();
