<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Utils;

final class Metric
{
	public static function duration(float $value): string
	{
		$value = abs($value);
		foreach (['s', 'ms', 'µs', 'ns'] as $unit) {
			if ($value > 1) {
				break;
			}

			$value *= 1000;
		}

		return number_format($value, 2, '.', ' ') . ' ' . $unit;
	}

	public static function bytes(int $value): string
	{
		$value = abs($value);
		foreach (['B', 'kB', 'MB', 'GB'] as $unit) {
			if ($value < 1024) {
				break;
			}

			$value /= 1024;
		}

		return number_format($value, 2, '.', ' ') . ' ' . $unit;
	}
}
