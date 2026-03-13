<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Bridge\Symfony;

use Matraux\PhpBenchmark\Measurement\Storage;
use Matraux\PhpBenchmark\Utils\Metric;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Output\OutputInterface;

final class BenchmarkPrinter
{
	public static function render(OutputInterface $output): void
	{
		$table = new Table($output);
		$table->setStyle('box');

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

		foreach (Storage::all() as $measurement) {
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
				$measurement->multiplier,
			]);
		}

		$table->render();
	}
}
