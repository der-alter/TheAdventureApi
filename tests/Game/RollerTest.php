<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Roller;
use App\Game\RollerInterface;
use PHPUnit\Framework\TestCase;

class RollerTest extends TestCase
{
    private RollerInterface $roller;

    public function setUp(): void
    {
        $this->roller = new Roller();
    }

    public function testRoll()
    {
        $num = $this->roller->roll('2D6');
        $this->assertTrue($num >= 1 && $num <= 12);

        $num = $this->roller->roll('1D4 -1');
        $this->assertTrue($num >= 0 && $num <= 3);
    }
}
