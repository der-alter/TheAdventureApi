<?php

declare(strict_types=1);

namespace App\Game;

use App\Game\Exception\CouldNotAttack;
use App\Game\Exception\CouldNotMove;
use App\Game\Exception\CouldNotRest;

class Adventure
{
    private const NB_TILES_BEFORE_BOSS = 10;

    private Character $character;
    private Monster $monster;
    private Tile $tile;
    private int $tileCount = 0;
    private int $healCount = 0;
    private int $score     = 0;

    private function __construct()
    {
    }

    public static function start(): self
    {
        $adventure            = new self();
        $adventure->character = Character::make();
        $adventure->monster   = Monster::make();
        $adventure->tile      = Tile::make();
        ++$adventure->tileCount;

        return $adventure;
    }

    public static function fromState(array $state): self
    {
        $adventure            = new self();
        $adventure->character = Character::fromState(...$state['character']);
        $adventure->monster   = Monster::fromState(...$state['monster']);
        $adventure->tile      = Tile::fromState(...$state['tile']);
        $adventure->tileCount = $state['tile_count'];
        $adventure->healCount = $state['heal_count'];
        $adventure->score     = $state['score'];

        return $adventure;
    }

    public function state(): array
    {
        return [
            'character'  => $this->character->state(),
            'monster'    => $this->monster->state(),
            'tile'       => $this->tile->state(),
            'tile_count' => $this->tileCount,
            'heal_count' => $this->healCount,
            'score'      => $this->score,
        ];
    }

    /**
     *  @throws CoulNotMove
     */
    public function move(RollerInterface $roller): void
    {
        $this->monster->attack($roller, $this->tile->scene(), $this->character);
        $this->character->takeDamage($this->tile->damage());
        $this->nextTile();
    }

    /**
     *  @throws CouldNotAttack
     */
    public function attack(RollerInterface $roller): void
    {
        if (false === $this->monster->alive()) {
            throw CouldNotAttack::fromDeadMonster();
        }
        $this->character->attack($roller, $this->monster);
    }

    public function rest(): void
    {
        if (false === $this->monster->alive() || $this->healCount > 0) {
            throw CouldNotRest::alreadyRested();
        }

        $this->character->heal();
    }

    private function nextTile(): void
    {
        if (true === $this->monster->alive() && Scene::SWAMP === $this->tile->scene()) {
            throw CouldNotMove::fromSwamp();
        }

        if (self::NB_TILES_BEFORE_BOSS === $this->tileCount) {
            $this->tile = Tile::make();
        } else {
            ++$this->tileCount;
            $this->healCount = 0;
            $this->tile      = Tile::make();
        }
    }
}
