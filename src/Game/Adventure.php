<?php

namespace App\Game;

class Adventure
{
    private Character $character;
    // private Monster $monster;
    // private Tile $currentTile;
    private int $tileCount = 0;

    public function __construct() {}

    public static function start() : self {
        $adventure = new self();
        $adventure->character = Character::make();
        // $this->monster = Monster::make();

        return $adventure;
    }

    public function state(): array
    {
        return [
            'character' => $this->character->state(),
            'tile_count' => $this->tileCount,
        ];
    }
}
