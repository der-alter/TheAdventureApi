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

    public function hp(): int
    {
        return $this->hp;
    }

    public function def(): int
    {
        return $this->def;
    }

    public function dice(): string
    {
        return $this->dice;
    }

    public function takeDamage(int $damage): void
    {
        if ($damage > 0) {
            $this->hp -= $damage;
        }
    }

    public function roll(RollerInterface $roller) {
        return $roller->roll($this->dice);
    }
}
