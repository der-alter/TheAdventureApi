<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Tile;
use PHPUnit\Framework\TestCase;

class TileTest extends TestCase
{
    public function testMake()
    {
        $tile  = Tile::make();
        $state = $tile->state();
        $this->assertArrayHasKey('scene', $state);
    }

    public function testFromState()
    {
        $state = ['scene'=> 'hills'];
        $tile  = Tile::fromState(...$state);
        $this->assertEquals($state, $tile->state());
    }
}
