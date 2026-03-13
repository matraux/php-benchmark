<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Benchmark;

use Matraux\PhpBenchmark\Measurement\Measurement;
use Matraux\PhpBenchmark\Measurement\Storage;
use UnexpectedValueException;

final class Benchmark
{
	public string $label {
		set => !empty($value) ? $value : throw new UnexpectedValueException('Expects "string", "empty string" given.');
		get => $this->label ??= uniqid('performance-');
	}

	/** @var int<1,max> */
	public int $counter = 1 {
		set => $value > 0 ? $value : throw new UnexpectedValueException(sprintf('Expects positive integer, "%u" given.', $value));
	}

	/** @var int<1,max> */
	public int $multiplier = 1 {
		set => $value > 0 ? $value : throw new UnexpectedValueException(sprintf('Expects positive integer, "%u" given.', $value));
	}

	public function run(callable $callable, mixed ...$arguments): Measurement
	{
		/** @var non-empty-array<int|float> $times */
		$times = [];
		memory_reset_peak_usage();
		$memory = memory_get_peak_usage();

		for ($m = 1; $m <= $this->multiplier; $m++) {
			$time = hrtime(true);

			ob_start();
			for ($n = 1; $n <= $this->counter; $n++) {
				$callable(...$arguments);
			}
			ob_end_clean();

			$times[] = (hrtime(true) - $time) / 1e9;
		}

		$memory = memory_get_peak_usage() - $memory;

		/** @var array{function:string,line:int,file:string,class:string,type:string} */
		$debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];

		$measurement = new Measurement(
			label: $this->label,
			counter: $this->counter,
			times: $times,
			memory: $memory,
			file: $debug['file'],
			line: $debug['line'],
		);

		return Storage::collect($measurement);
	}
}
