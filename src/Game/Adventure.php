<?php

declare(strict_types=1);

namespace App\Game;

class Adventure
{
    private const NB_TILES_BEFORE_BOSS = 10;

    private Character $character;
    private Monster $monster;
    private Tile $tile;
    private int $tileCount = 0;
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
            'score'      => $this->score,
        ];
    }

    /**
     *  @throws CoulNotMove
     */
    public function move(RollerInterface $roller): void
    {
        if (true === $this->monster->alive()) {
            $monsterAtk = $this->monster->attack($roller, $this->tile->scene());
            $this->character->takeDamage($monsterAtk);
        }

        if (true === $this->monster->alive() && Scene::SWAMP === $this->tile->scene()) {
            throw CoulNotMove::fromSwamp();
        }

        $this->nextTile();
    }

    private function nextTile(): void
    {
        if (self::NB_TILES_BEFORE_BOSS === $this->tileCount) {
            $this->tile = Tile::make();
        } else {
            ++$this->tileCount;
            $this->tile = Tile::make();
        }
    }
}
