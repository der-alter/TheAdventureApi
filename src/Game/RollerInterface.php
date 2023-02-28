<?php

declare(strict_types=1);

namespace App\Game;

interface RollerInterface
{
    public function roll(string $dice): int;
}
