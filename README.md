# Advent Of Code 2026

## Installation

Copy `.env.example` to `.env` and set the environment variable called `AOC_SESSION` with the session cookie of adventofcode.com

Optional: `AOC_YEAR` (default 2026) and `AOC_USER_AGENT` (AoC asks automated tools to include contact info).

## Usage

```bash
php aoc make 1                  # creates day01/ (solution.php, example.txt) and downloads input.txt
php aoc run 1                   # runs both parts on input.txt
php aoc run 1 --part=2          # runs only part 2
php aoc run 1 --test            # runs on example.txt
```

`make` never overwrites a solution or re-downloads an existing input. Inputs are gitignored.
