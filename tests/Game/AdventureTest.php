<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Adventure;
use App\Game\RollerInterface;
use PHPUnit\Framework\TestCase;

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

class AdventureTest extends TestCase
{
    public function testStart()
    {
        $adventure = Adventure::start();
        $state     = $adventure->state();
        $this->assertEquals(20, $state['character']['hp']);
        $this->assertEquals(1, $state['tile_count']);
    }

    public function testFromState()
    {
        $state = [
            'character'  => ['hp' => 34, 'def' => 5],
            'tile'       => ['scene' => 'hills'],
            'monster'    => ['breed' => 'goblin', 'hp' => 34],
            'tile_count' => 5,
            'score'      => 0,
        ];
        $adventure = Adventure::fromState($state);
        $this->assertEquals($state, $adventure->state());
    }

    public function testMoveWithDeadMonster()
    {
        $state = [
            'character'  => ['hp' => 34, 'def' => 5],
            'tile'       => ['scene' => 'hills'],
            'monster'    => ['breed' => 'goblin', 'hp' => 0],
            'tile_count' => 5,
            'score'      => 0,
        ];
        $adventure = Adventure::fromState($state);
        $adventure->move(new FakeRoller(4));
        $this->assertEquals(6, $adventure->state()['tile_count']);
    }

    public function testMoveWithMonsterAtk()
    {
        $state = [
            'character'  => ['hp' => 34, 'def' => 5],
            'tile'       => ['scene' => 'hills'],
            'monster'    => ['breed' => 'goblin', 'hp' => 12],
            'tile_count' => 5,
            'score'      => 0,
        ];
        $adventure = Adventure::fromState($state);
        $adventure->move(new FakeRoller(4));
        $this->assertEquals(6, $adventure->state()['tile_count']);

        // no damage
        $this->assertEquals(34, $adventure->state()['character']['hp']);
    }

    public function testMoveWithMonsterAtkAndBonus()
    {
        $state = [
            'character'  => ['hp' => 10, 'def' => 5],
            'tile'       => ['scene' => 'forest'],
            'monster'    => ['breed' => 'goblin', 'hp' => 12],
            'tile_count' => 5,
            'score'      => 0,
        ];
        $adventure = Adventure::fromState($state);
        $adventure->move(new FakeRoller(4));
        $this->assertEquals(6, $adventure->state()['tile_count']);

        // damage taken (atk + bonus) - def = (4 + 2) - 5
        $this->assertEquals(9, $adventure->state()['character']['hp']);
    }
}
