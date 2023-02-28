<?php

declare(strict_types=1);

namespace App\Game;

class Adventure
{
    private Character $character;
    private Tile $tile;
    private int $tileCount = 0;

    private function __construct()
    {
    }

    public static function start(): self
    {
        $adventure            = new self();
        $adventure->character = Character::make();
        $adventure->tile      = Tile::make();
        ++$adventure->tileCount;

        return $adventure;
    }

    public static function fromState(array $state): self
    {
        $adventure            = new self();
        $adventure->character = Character::fromState(...$state['character']);
        $adventure->tile      = Tile::fromState(...$state['tile']);
        $adventure->tileCount = $state['tile_count'];

        return $adventure;
    }

    public function state(): array
    {
        return [
            'character'  => $this->character->state(),
            'tile'       => $this->tile->state(),
            'tile_count' => $this->tileCount,
        ];
    }

    public function move(RollerInterface $roller): void
    {
        if (false === $this->tile->isMonsterAlive()) {
            ++$this->tileCount;
            $this->tile = Tile::make();
        } else {
            $monsterAtk = $this->tile->monsterAtk($roller);
            $this->character->takeDamage($monsterAtk - $this->character->def());
        }
    }
}
