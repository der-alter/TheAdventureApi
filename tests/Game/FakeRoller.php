<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\RollerInterface;

class FakeRoller implements RollerInterface
{
    public function __construct(private int $num)
    {
    }

    public function roll(string $dice): int
    {
        return $this->num;
    }
}
