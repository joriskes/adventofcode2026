<?php

namespace Aoc;

use RuntimeException;

final readonly class Client
{
    public function __construct(
        private string $session,
        private string $userAgent,
    ) {}

    public function input(int $year, int $day): string
    {
        $unlock = gmmktime(5, 0, 0, 12, $day, $year);
        if (time() < $unlock) {
            throw new RuntimeException(sprintf('Day %d of %d unlocks at %s UTC.', $day, $year, gmdate('Y-m-d H:i', $unlock)));
        }

        $context = stream_context_create(['http' => [
            'header' => "Cookie: session={$this->session}\r\nUser-Agent: {$this->userAgent}\r\n",
            'ignore_errors' => true,
        ]]);

        $body = @file_get_contents("https://adventofcode.com/{$year}/day/{$day}/input", false, $context);
        if ($body === false) {
            throw new RuntimeException('Could not reach adventofcode.com.');
        }

        $status = (int) explode(' ', http_get_last_response_headers()[0] ?? '')[1];
        if ($status !== 200) {
            $detail = str_starts_with(ltrim($body), '<') ? 'check AOC_SESSION, it may be invalid or expired' : trim($body);
            throw new RuntimeException(sprintf('Input download failed (HTTP %d): %s', $status, $detail));
        }

        return $body;
    }
}
