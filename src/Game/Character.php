<?php

declare(strict_types=1);

namespace App\Game;

final class Character
{
    private int $hp      = 20;
    private int $def     = 5;
    private string $dice = '2D6';

    private function __construct()
    {
    }

    public static function make(): self
    {
        return new self();
    }

    public static function fromState(int $hp, int $def): self
    {
        $character      = new self();
        $character->hp  = $hp;
        $character->def = $def;

        return $character;
    }

    public function state()
    {
        return [
            'hp'  => $this->hp,
            'def' => $this->def,
        ];
    }

    public function takeDamage(int $atk): void
    {
        $damage = $atk - $this->def;

        if ($damage > 0) {
            $this->hp -= $damage;
        }
    }

    public function roll(RollerInterface $roller)
    {
        return $roller->roll($this->dice);
    }
}
