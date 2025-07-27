<?php declare(strict_types = 1);

namespace Matraux\PhpBenchmark\Bridge\Symfony;

use Matraux\PhpBenchmark\Measurement\MeasurementStorage;
use Matraux\PhpBenchmark\Utils\Metric;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Style\SymfonyStyle;

final class BenchmarkPrinter
{

	public static function render(SymfonyStyle $io): void
	{
		$table = $io->createTable();

		$table->setHeaders([
			'Label',
			'Min',
			'Max',
			'Average',
			'Deviation',
			'Total',
			'Memory',
			'Counter',
			'Multiplier',
		]);
		$table->setStyle('box');

		foreach(MeasurementStorage::create() as $measurement) {
			$table->addRow([
				$measurement->label,
				Metric::duration($measurement->min),
				Metric::duration($measurement->max),
				new TableCell(Metric::duration($measurement->average), [
					'style' => new TableCellStyle([
						'fg' => 'cyan',
					]),
				]),
				Metric::duration($measurement->deviation),
				Metric::duration($measurement->total),
				Metric::bytes($measurement->memory),
				$measurement->counter,
				$measurement->multiplier
			]);
		}

		$table->render();
	}

}