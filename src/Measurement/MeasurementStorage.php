<?php declare(strict_types = 1);

namespace Matraux\PhpBenchmark\Measurement;

use Countable;
use IteratorAggregate;
use LogicException;
use Traversable;

/**
 * @implements IteratorAggregate<int,Measurement>
 */
final class MeasurementStorage implements Countable, IteratorAggregate
{

	protected static self $instance;

	/** @var array<int,Measurement> */
	protected static array $results = [];

	protected function __construct()
	{
	}

	public static function create(): static
	{
		return self::$instance ??= new static();
	}

	public static function add(Measurement $result): Measurement
	{
		return self::$results[] = $result;
	}

	public function getIterator(): Traversable
	{
		yield from self::$results;
	}

	public function count(): int
	{
		return count(self::$results);
	}

	public function __clone(): void
	{
		throw new LogicException(sprintf('Clone %s is not allowed.', self::class));
	}

	public function __sleep(): array
	{
		throw new LogicException(sprintf('Serialize %s is not allowed.', self::class));
	}

	public function __wakeup(): void
	{
		throw new LogicException(sprintf('Unserialize %s is not allowed.', self::class));
	}

}
