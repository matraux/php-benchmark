<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Measurement;

final class Storage
{
	/** @var array<int,Measurement> */
	protected static array $measurements = [];

	protected function __construct() {}

	/**
	 * @return array<int,Measurement>
	 */
	public static function all(): array
	{
		return static::$measurements;
	}

	public static function clear(): void
	{
		static::$measurements = [];
	}

	public static function collect(Measurement $measurement): Measurement
	{
		return static::$measurements[] = $measurement;
	}
}
