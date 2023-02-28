<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Character;
use App\Game\Monster;
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
            'take positive damage' => [['hp' => 8, 'def' => 5], 6, 2],
            'take negative damage' => [['hp' => 3, 'def' => 5], -4, 3],
        ];
    }

    /**
     * @dataProvider provideFight
     */
    public function testFight(array $state, int $atk, int $expected)
    {
        $character = Character::fromState(...$state);
        $character->fight($atk);
        $this->assertEquals($expected, $character->fight($atk));
    }

    public static function provideFight()
    {
        return [
            [['hp' => 3, 'def' => 5], 6, 1],
            [['hp' => 3, 'def' => 5], 7, 2],
        ];
    }

    /**
     * @dataProvider provideAttack
     */
    public function testAttack(array $character, int $atk, array $monster, int $expected)
    {
        $roller    = new FakeRoller($atk);
        $character = Character::fromState(...$character);
        $monster   = Monster::fromState(...$monster);
        $character->attack($roller, $monster);
        $this->assertEquals($expected, $character->fight($atk));
    }

    public static function provideAttack()
    {
        return [
            [['hp' => 3, 'def' => 5], 6, ['breed' => 'goblin', 'hp' => 34], 1],
            [['hp' => 3, 'def' => 5], 7, ['breed' => 'goblin', 'hp' => 34], 2],
        ];
    }
}
