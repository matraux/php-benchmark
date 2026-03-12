<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Measurement;

use JsonSerializable;
use RuntimeException;
use Stringable;

final class Measurement implements JsonSerializable, Stringable
{
	public float $average {
		get => $this->average ??= $this->total / $this->multiplier;
	}

	public float $min {
		get => $this->min ??= min($this->times);
	}

	public float $max {
		get => $this->max ??= max($this->times);
	}

	public float $total {
		get => $this->total ??= array_sum($this->times);
	}

	public int $multiplier {
		get => $this->multiplier ??= count($this->times);
	}

	public float $deviation {
		get {
			if (isset($this->deviation)) {
				return $this->deviation;
			}

			$variance = 0;
			foreach ($this->times as $time) {
				$variance += pow($time - $this->average, 2);
			}

			return $this->deviation = sqrt($variance / $this->multiplier);
		}
	}

	/**
	 * @param non-empty-array<int|float> $times
	 */
	protected function __construct(
		public readonly string $label,
		public readonly int $counter,
		public readonly array $times,
		public readonly int $memory,
		public readonly ?string $file = null,
		public readonly ?int $line = null,
	) {
		MeasurementStorage::add($this);
	}

	/**
	 * @param array<int|float> $times
	 */
	public static function create(string $label, int $counter, array $times, int $memory, ?string $file = null, ?int $line = null): static
	{
		if (empty($times)) {
			throw new RuntimeException('Expects non empty array, empty array given.');
		}

		return new static($label, $counter, $times, $memory, $file, $line);
	}

	/**
	 * @return array<string,int|float|string|null>
	 */
	public function jsonSerialize(): array
	{
		return [
			'Average' => $this->average,
			'Min' => $this->min,
			'Max' => $this->max,
			'Total' => $this->total,
			'Deviation' => $this->deviation,
			'Multiplier' => $this->multiplier,
			'Label' => $this->label,
			'Counter' => $this->counter,
			'Memory' => $this->memory,
			'File' => $this->file,
			'Line' => $this->line,
		];
	}

	public function __toString(): string
	{
		$string = '';
		foreach ($this->jsonSerialize() as $label => $value) {
			$string .= sprintf("%s: %s\n", $label, $value);
		}

		return $string;
	}
}
