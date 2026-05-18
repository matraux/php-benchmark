<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Measurement;

use JsonSerializable;
use RuntimeException;
use Stringable;

final readonly class Measurement implements JsonSerializable, Stringable
{
	public float $average;

	public float $min;

	public float $max;

	public float $total;

	public int $multiplier;

	public float $deviation;

	/**
	 * @param non-empty-array<int|float> $times
	 */
	public function __construct(
		public string $label,
		public int $counter,
		public array $times,
		public int $memory,
		public ?string $file = null,
		public ?int $line = null,
	) {
		if (empty($times)) {
			throw new RuntimeException('Expects non empty array, empty array given.');
		}

		$this->min = min($this->times);
		$this->max = max($this->times);
		$this->total = array_sum($this->times);
		$this->multiplier = count($this->times);
		$this->average = $this->total / $this->multiplier;

		$variance = 0;
		foreach ($this->times as $time) {
			$variance += ($time - $this->average) ** 2;
		}
		$this->deviation = sqrt($variance / $this->multiplier);
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
