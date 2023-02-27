<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Adventure;
use PHPUnit\Framework\TestCase;

class AdventureTest extends TestCase
{
    public function testStart()
    {
        $adventure = Adventure::start();
        $state = $adventure->state();
        $this->assertEquals(20, $state['character']['hp']);
        $this->assertEquals(0, $state['tile_count']);
    }
}
