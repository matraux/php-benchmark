<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Bridge\Tracy;

use Matraux\PhpBenchmark\Measurement\Measurement;
use Matraux\PhpBenchmark\Measurement\Storage;
use Tracy\Helpers;
use Tracy\IBarPanel;

final class BenchmarkPanel implements IBarPanel
{
	private const string Images = __DIR__ . '/images/';

	private const string Templates = __DIR__ . '/templates/';

	public static function editorLink(Measurement $measurement): ?string
	{
		return $measurement->file ? Helpers::editorLink($measurement->file, $measurement->line) : null;
	}

	public function getTab(): string
	{
		if (empty(Storage::all())) {
			return '';
		}

		return Helpers::capture(function (): void {
			$svg = file_get_contents(self::Images . 'speedometer.min.svg');
			require self::Templates . 'BenchmarkPanel.tab.phtml';
		});
	}

	public function getPanel(): string
	{
		if (empty(Storage::all())) {
			return '';
		}

		return Helpers::capture(function (): void {
			$results = Storage::all();
			require self::Templates . 'BenchmarkPanel.panel.phtml';
		});
	}
}
