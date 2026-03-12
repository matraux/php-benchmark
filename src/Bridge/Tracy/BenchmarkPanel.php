<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Bridge\Tracy;

use Matraux\PhpBenchmark\Measurement\Measurement;
use Matraux\PhpBenchmark\Measurement\MeasurementStorage;
use Nette\Utils;
use Nette\Utils\FileSystem;
use Tracy\Helpers;
use Tracy\IBarPanel;

final class BenchmarkPanel implements IBarPanel
{
	private const Images = __DIR__ . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

	private const Templates = __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;

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
