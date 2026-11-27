<?php

namespace Aoc;

use RuntimeException;

final readonly class Runner
{
    public function __construct(private string $dir) {}

    /**
     * @param list<int> $parts
     * @return list<array{int, string, string}>
     */
    public function run(array $parts, bool $test): array
    {
        $file = $this->dir . ($test ? '/example.txt' : '/input.txt');
        if (!is_file($file)) {
            throw new RuntimeException("Missing {$file}");
        }
        $input = rtrim(file_get_contents($file), "\n");
        $solution = require $this->dir . '/solution.php';

        $results = [];
        foreach ($parts as $part) {
            $start = hrtime(true);
            $answer = $solution->{"part{$part}"}($input);
            $ms = (hrtime(true) - $start) / 1e6;

            $results[] = [$part, var_export($answer, true), sprintf('%.2f ms', $ms)];
        }

        return $results;
    }
}
