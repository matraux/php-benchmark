**[Back](../Readme.md)**

# Standalone Usage
You can use the benchmark independently, without any framework or Tracy integration.

## Sample measurement code
```php
use Matraux\PhpBenchmark\Benchmark\Benchmark;

$performance = Benchmark::create();
$performance->counter = 10;
$performance->multiplier = 2;

$performance->label = 'Memory peak 20 MB';
$measurement = $performance->run(function (): string {
	return str_repeat(' ', 20 * 1024 * 1024);
});
```

### Measurement properties
```php
echo $measurement->label;      // string - user-defined label (e.g. "Memory peak 20 MB")
echo $measurement->counter;    // int - number of executions per run (e.g. 10)
echo $measurement->multiplier; // int - number of total runs (e.g. 2)
echo $measurement->memory;     // int - peak memory usage across all runs in bytes (e.g. 23085424)
echo $measurement->total;      // float - total time in seconds (e.g. 0.08786669999999999)
echo $measurement->average;    // float - average time in seconds per run (e.g. 0.043933349999999996)
echo $measurement->min;        // float - shortest time in seconds from all runs (e.g. 0.04393)
echo $measurement->max;        // float - longest time in seconds from all runs (e.g. 0.0439367)
echo $measurement->deviation;  // float - standard deviation (e.g. 0.0000033500000000026564)
echo $measurement->file;       // ?string - file where the benchmark was called (e.g. /path/to/test.php)
echo $measurement->line;       // ?int - line where the benchmark was called (e.g. 19)
```

### Stringable
```php
echo $measurement;
```
```txt
Average: 0.043933349999999996
Min: 0.04393
Max: 0.0439367
Total: 0.08786669999999999
Deviation: 0.0000033500000000026564
Multiplier: 2
Label: Memory peak 20 MB
Counter: 10
Memory: 23085424
File: /path/to/test.php
Line: 19
```

### JSON Serialization
```php
echo json_encode($measurement);
```
```json
{
	"Average":0.043933349999999996,
	"Min":0.04393,
	"Max":0.0439367,
	"Total":0.08786669999999999,
	"Deviation":0.0000033500000000026564,
	"Multiplier":2,
	"Label":"Memory peak 20 MB",
	"Counter":10,
	"Memory":23085424,
	"File":"/path/to/test.php",
	"Line":19
}
```