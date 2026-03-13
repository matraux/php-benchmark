<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Test\Unit;

use Matraux\PhpBenchmark\Benchmark\Benchmark;
use Matraux\PhpBenchmark\Test\Support\UnitTester;

final class BenchmarkCest
{
	public function testRun(UnitTester $tester): void
	{
		$benchmark = new Benchmark();
		$benchmark->run(function (...$arguments): void {
			print_r($arguments);
		}, 'T', 'e', 's', 't');
	}
}
