<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Character;
use PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase
{
    public function testMake()
    {
        $character = Character::make();
        $this->assertEquals(['hp'=>20], $character->state());
    }

    public function testFromState()
    {
        $state     = ['hp' => 34];
        $character = Character::fromState(...$state);
        $this->assertEquals($state, $character->state());
    }

    public function testTakeDamage()
    {
        $state     = ['hp' => 3];
        $character = Character::fromState(...$state);
        $character->takeDamage(2);
        $this->assertEquals(1, $character->hp());
        $character->takeDamage(-3);
        $this->assertEquals(1, $character->hp());
    }
}
