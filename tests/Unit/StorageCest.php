<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Test\Unit;

use Matraux\PhpBenchmark\Measurement\Measurement;
use Matraux\PhpBenchmark\Measurement\Storage;
use Matraux\PhpBenchmark\Test\Support\UnitTester;

final class StorageCest
{
	public function testCountable(UnitTester $tester): void
	{
		$measurement = new Measurement('', 0, [0], 0);

		Storage::clear();
		$tester->assertCount(0, Storage::all());

		Storage::collect($measurement);
		$tester->assertCount(1, Storage::all());

		Storage::collect($measurement);
		$tester->assertCount(2, Storage::all());
	}

	public function testArray(UnitTester $tester): void
	{
		$measurement = new Measurement('', 0, [0], 0);
		Storage::collect($measurement);

		foreach (Storage::all() as $measurement) {
		}
	}
}
