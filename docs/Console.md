**[Back](../README.md)**

# Symfony Console integration
The benchmark output can be printed as a styled table in any Symfony Console command.

## Sample measurement code
```php
use Matraux\PhpBenchmark\Benchmark\Benchmark;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Matraux\PhpBenchmark\Bridge\Symfony\BenchmarkPrinter;

new class extends Command {
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$benchmark = new Benchmark;
		$benchmark->label = 'Memory peak 20 MB';
		$benchmark->counter = 10;
		$benchmark->multiplier = 2;

		$benchmark->run(function (): string {
			return str_repeat(' ', 20 * 1024 * 1024);
		});

		BenchmarkPrinter::render($output);

		return Command::SUCCESS;
	}
}->run( new ArgvInput(), new ConsoleOutput() );
```

```bash
┌───────────────────┬──────────┬──────────┬──────────┬───────────┬──────────┬──────────┬─────────┬────────────┐
│ Label             │ Min      │ Max      │ Average  │ Deviation │ Total    │ Memory   │ Counter │ Multiplier │
├───────────────────┼──────────┼──────────┼──────────┼───────────┼──────────┼──────────┼─────────┼────────────┤
│ Memory peak 20 MB │ 45.28 ms │ 47.54 ms │ 46.41 ms │ 1.13 ms   │ 92.82 ms │ 22.02 MB │ 10      │ 2          │
└───────────────────┴──────────┴──────────┴──────────┴───────────┴──────────┴──────────┴─────────┴────────────┘
```