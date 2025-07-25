<?php declare(strict_types = 1);

namespace Matraux\PhpBenchmark\Tracy;

use Matraux\PhpBenchmark\Measurement\MeasurementStorage;
use Matraux\PhpBenchmark\Measurement\Measurement;
use Nette\Utils;
use Nette\Utils\FileSystem;
use Tracy\Helpers;
use Tracy\IBarPanel;

final class BenchmarkPanel implements IBarPanel
{

	private const Images = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

	private const Templates = __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;

	public static function formatTime(float $value): string
	{
		$value = abs($value);
		foreach (['s', 'ms', 'µs', 'ns'] as $unit) {
			if ($value > 1) {
				break;
			}

			$value *= 1000;
		}

		return sprintf('%u %s', number_format($value, 2, '.', ' '), $unit);
	}

	public static function formatBytes(int $value): string
	{
		$value = abs($value);
		foreach (['B', 'kB', 'MB', 'GB'] as $unit) {
			if ($value < 1024) {
				break;
			}

			$value /= 1024;
		}

		return sprintf('%u %s', number_format($value, 2, '.', ' '), $unit);
	}

	public static function editorLink(Measurement $result): ?string
	{
		return $result->file ? Helpers::editorLink($result->file, $result->line) : null;
	}

	public function getTab(): string
	{
		if (!count(MeasurementStorage::create())) {
			return '';
		}

		return Utils\Helpers::capture(function (): void {
			$svg = FileSystem::read(self::Images . 'speedometer.min.svg');
			require_once self::Templates . 'BenchmarkPanel.tab.phtml';
		});
	}

	public function getPanel(): string
	{
		if (!count(MeasurementStorage::create())) {
			return '';
		}

		return Utils\Helpers::capture(function (): void {
			$results = MeasurementStorage::create();
			require_once self::Templates . 'BenchmarkPanel.panel.phtml';
		});
	}

}
