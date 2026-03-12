<?php declare(strict_types=1);

namespace Matraux\PhpBenchmarkTest;

use Matraux\PhpBenchmark\Benchmark\Benchmark;
use Tester\Assert;
use Tester\TestCase;
use UnexpectedValueException;

require_once __DIR__ . '/Bootstrap.php';

Bootstrap::tester();

/**
 * @testCase
 */
final class BenchmarkTest extends TestCase
{
	public function testInstance(): void
	{
		$benchmark = Benchmark::create();

		Assert::type(Benchmark::class, $benchmark);
	}

	public function testProperties(): void
	{
		$benchmark = Benchmark::create();

		Assert::error(function (): void {
			Benchmark::create()->label = '';
		}, UnexpectedValueException::class);

		Assert::error(function () use ($benchmark): void {
			$benchmark->counter = 0; // @phpstan-ignore-line
		}, UnexpectedValueException::class);

		Assert::error(function () use ($benchmark): void {
			$benchmark->multiplier = 0; // @phpstan-ignore-line
		}, UnexpectedValueException::class);
	}

	public function testRun(): void
	{
		$benchmark = Benchmark::create();

		Assert::noError(function () use ($benchmark): void {
			$benchmark->run(function (...$arguments): void {
				print_r($arguments);
			}, 'T', 'e', 's', 't');
		});
	}
}

new BenchmarkTest()->run();
