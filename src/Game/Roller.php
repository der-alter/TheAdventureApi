<?php

declare(strict_types=1);

namespace App\Game;

final class Roller implements RollerInterface
{
    public function roll(string $dice): int
    {
        if (false !== preg_match_all('/^(\d)D(\d)( -\d)?$/', $dice, $matches)) {
            return random_int(1, (int) $matches[2][0]) * (int) $matches[1][0] + (int) ($matches[3][0] ?? 0);
        }

        return 0;
    }
}
