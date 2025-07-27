# MATRAUX PHP Benchmark
[![Latest Version on Packagist](https://img.shields.io/packagist/v/matraux/php-benchmark.svg?logo=packagist&logoColor=white)](https://packagist.org/packages/matraux/php-benchmark)
[![Last release](https://img.shields.io/github/v/release/matraux/php-benchmark?display_name=tag&logo=github&logoColor=white)](https://github.com/matraux/php-benchmark/releases)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg?logo=open-source-initiative&logoColor=white)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-8.4+-blue.svg?logo=php&logoColor=white)](https://php.net)
[![Security Policy](https://img.shields.io/badge/Security-Policy-blue?logo=bitwarden&logoColor=white)](./.github/SECURITY.md)
[![Contributing](https://img.shields.io/badge/Contributing-Disabled-lightgrey?logo=github&logoColor=white)](CONTRIBUTING.md)
[![QA Status](https://img.shields.io/github/actions/workflow/status/matraux/php-benchmark/qa.yml?label=Quality+Assurance&logo=checkmarx&logoColor=white)](https://github.com/matraux/php-benchmark/actions/workflows/qa.yml)
[![Issues](https://img.shields.io/github/issues/matraux/php-benchmark?logo=github&logoColor=white)](https://github.com/matraux/php-benchmark/issues)
[![Last Commit](https://img.shields.io/github/last-commit/matraux/php-benchmark?logo=git&logoColor=white)](https://github.com/matraux/php-benchmark/commits)

<br>

## Introduction
Simple and precise benchmarking for PHP 8.4+. Measures execution time and memory usage of code blocks with minimal overhead.

<br>

## Features
- High-precision time and memory measurement
- Clean and readable syntax for benchmarking code blocks
- Support for named measurements and grouped runs
- Easy integration via callable or closure wrapping
- Fluent API for accessing results
- Minimal overhead, suitable for micro-benchmarking
- Native support for PHP 8.4+ features
- Integrates with Tracy for real-time benchmark visualization

<br>

## Installation
```bash
composer require matraux/php-benchmark
```

<br>

## Requirements
| version | PHP | Note
|----|---|---
| 1.0.7 | 8.3+ | Initial commit
| 1.1.0 | 8.4+ | Property access, performance optimizations
| 1.1.1 | 8.4+ | Bugfixes and formatting improvements
| 1.2.0 | 8.4+ | Integrations into Bridge/Tracy

<br>

## Examples
See [Tracy](./docs/Tracy.md), [Standalone](./docs/Standalone.md) or [Console](./docs/Console.md) integration for advanced instructions.
```php
use Matraux\PhpBenchmark\Benchmark\Benchmark;

$benchmark = Benchmark::create();
$benchmark->label = 'Memory peak 20 MB';
$benchmark->counter = 10;
$benchmark->multiplier = 2;

$measurement = $benchmark->run(function (): string {
	return str_repeat(' ', 20 * 1024 * 1024);
});

echo $measurement->average; // Print average time (e.g. 44 ms)
echo $measurement->memory; // Print peak memory usage (e.g. 22 MB)
```

<br>

## Development
See [Development](./docs/Development.md) for debug, test instructions, static analysis, and coding standards.

<br>

## Support
For bug reports and feature requests, please use the [issue tracker](https://github.com/matraux/php-benchmark/issues).