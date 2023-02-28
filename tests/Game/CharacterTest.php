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
        $this->assertEquals(['hp'=>20, 'def' => 5], $character->state());
    }

    public function testFromState()
    {
        $state     = ['hp' => 34, 'def' => 5];
        $character = Character::fromState(...$state);
        $this->assertEquals($state, $character->state());
    }

    /**
     * @dataProvider provideDamage
     */
    public function testTakeDamage(array $state, int $atk, int $expected)
    {
        $character = Character::fromState(...$state);
        $character->takeDamage($atk);
        $this->assertEquals($expected, $character->state()['hp']);
    }

    public static function provideDamage()
        {
            return [
                [['hp' => 3, 'def' => 5], 6, 2],
                [['hp' => 3, 'def' => 5], 7, 1],
            ];
        }
}
