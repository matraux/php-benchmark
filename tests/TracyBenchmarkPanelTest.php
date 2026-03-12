<?php declare(strict_types=1);

namespace Matraux\PhpBenchmarkTest;

use Matraux\PhpBenchmark\Bridge\Tracy\BenchmarkPanel;
use Tester\Assert;
use Tester\TestCase;
use Tracy\Debugger;

require_once __DIR__ . '/Bootstrap.php';

Bootstrap::tester();

/**
 * @testCase
 */
final class TracyBenchmarkPanelTest extends TestCase
{
	public function testAddPanel(): void
	{
		Assert::noError(function (): void {
			Debugger::getBar()->addPanel(new BenchmarkPanel());
		});
	}
}

new TracyBenchmarkPanelTest()->run();
