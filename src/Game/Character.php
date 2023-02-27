<?php

declare(strict_types=1);

namespace App\Game;

final class Character
{
    private int $hp  = 20;
    private int $def = 5;

    private function __construct()
    {
    }

    public static function make(): self
    {
        return new self();
    }

    public static function fromState(int $hp): self
    {
        $character     = new self();
        $character->hp = $hp;

        return $character;
    }

    public function state()
    {
        return [
            'hp' => $this->hp,
        ];
    }
}
