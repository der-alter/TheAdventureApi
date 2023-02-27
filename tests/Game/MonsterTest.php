<?php

namespace App\Tests\Game;

use App\Game\Monster;
use PHPUnit\Framework\TestCase;

class MonsterTest extends TestCase
{
    public function testMake()
    {
        $monster = Monster::make();
        $state = $monster->state();
        $this->assertArrayHasKey('breed', $state);
        $this->assertArrayHasKey('hp', $state);
    }

    public function testFromState() {
        $state = ['breed' => 'goblin', 'hp' => 34];
        $monster = Monster::fromState(...$state);
        $this->assertEquals($state, $monster->state());
    }
}
