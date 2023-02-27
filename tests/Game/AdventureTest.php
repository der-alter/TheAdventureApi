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
        $state     = $adventure->state();
        $this->assertEquals(20, $state['character']['hp']);
        $this->assertEquals(0, $state['tile_count']);
    }

    public function testFromState()
    {
        $state = [
            'character'  => ['hp' => 34],
            'tile'       => ['scene' => 'hills', 'monster' => ['breed' => 'goblin', 'hp' => 34]],
            'tile_count' => 1,
        ];
        $adventure = Adventure::fromState($state);
        $this->assertEquals($state, $adventure->state());
    }
}
