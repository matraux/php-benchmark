<?php declare(strict_types = 1);

namespace Matraux\PhpBenchmark\Benchmark;

use Matraux\PhpBenchmark\Measurement\Measurement;
use UnexpectedValueException;

final class Benchmark
{

	public string $label
	{
		set {
			if (empty($value)) {
				throw new UnexpectedValueException('Expected "string", "empty string" given.');
			}

			$this->label = $value;
		}
		get {
			return $this->label ??= uniqid('performance-');
		}
	}

	/** @var int<1,max> */
	public int $counter = 1
	{
		set {
			if ($value <= 0) {
				throw new UnexpectedValueException(sprintf('Expected positive integer, "%u" given', $value));
			}

			$this->counter = $value;
		}
		get {
			return $this->counter;
		}
	}

	/** @var int<1,max> */
	public int $multiplier = 1
	{
		set {
			if ($value <= 0) {
				throw new UnexpectedValueException(sprintf('Expected positive integer, "%u" given', $value));
			}

			$this->multiplier = $value;
		}
		get {
			return $this->multiplier;
		}
	}

	protected function __construct()
	{
	}

	public static function create(): static
	{
		return new static();
	}

	public function run(callable $callable, mixed ...$arguments): Measurement
	{
		$times = [];
		memory_reset_peak_usage();
		$memory = memory_get_peak_usage();

		for ($m = 1; $m <= $this->multiplier; $m++) {
			$time = hrtime(true);

			ob_start(fn () => '');
			for ($n = 1; $n <= $this->counter; $n++) {
				$callable(...$arguments);
			}

			ob_end_clean();

			$times[] = (hrtime(true) - $time) / 1e9;
		}

		$memory = memory_get_peak_usage() - $memory;

		/** @var array{function:string,line:int,file:string,class:string,type:string} */
		$debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[0];

		return Measurement::create(
			label: $this->label,
			counter: $this->counter,
			times: $times,
			memory: $memory,
			file: $debug['file'],
			line: $debug['line']
		);
	}

}
