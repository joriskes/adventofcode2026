<?php

namespace Aoc;

use RuntimeException;

final readonly class Runner
{
    public function __construct(private string $dir) {}

    /** @param list<int> $parts */
    public function run(array $parts, bool $test): void
    {
        $file = $this->dir . ($test ? '/example.txt' : '/input.txt');
        if (!is_file($file)) {
            throw new RuntimeException("Missing {$file}");
        }
        $input = rtrim(file_get_contents($file), "\n");
        $solution = require $this->dir . '/solution.php';

        foreach ($parts as $part) {
            $start = hrtime(true);
            $answer = $solution->{"part{$part}"}($input);
            $ms = (hrtime(true) - $start) / 1e6;

            printf('Part %d: %s (%.2f ms)%s', $part, var_export($answer, true), $ms, PHP_EOL);
        }
    }
}
