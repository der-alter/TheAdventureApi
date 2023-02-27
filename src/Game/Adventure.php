<?php

namespace App\Game;

class Adventure
{
    private Character $character;
    // private Monster $monster;
    private Tile $tile;
    private int $tileCount = 0;

    public function __construct() {}

    public static function start() : self {
        $adventure = new self();
        $adventure->character = Character::make();
        $adventure->tile = Tile::make();

        return $adventure;
    }

    public function state(): array
    {
        return [
            'character' => $this->character->state(),
            'tile' => $this->tile->state(),
            'tile_count' => $this->tileCount,
        ];
    }
}
