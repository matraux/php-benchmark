<?php declare(strict_types=1);

namespace Matraux\PhpBenchmark\Test\Unit;

use Matraux\PhpBenchmark\Bridge\Tracy\BenchmarkPanel;
use Matraux\PhpBenchmark\Test\Support\UnitTester;
use Tracy\Debugger;

final class TracyBenchmarkPanelCest
{
	public function testAddPanel(UnitTester $tester): void
	{
		Debugger::getBar()->addPanel(new BenchmarkPanel());
	}
}
