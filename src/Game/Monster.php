<?php

declare(strict_types=1);

namespace App\Game;

enum Breed: string
{
    case Ghost  = 'ghost';
    case Goblin = 'goblin';
    case Ork    = 'ork';
    case Troll  = 'troll';

    public function hp(): int
    {
        return match ($this) {
            Breed::Ghost  => 8,
            Breed::Goblin => 12,
            Breed::Ork    => 10,
            Breed::Troll  => 12,
        };
    }

    public function def(): int
    {
        return match ($this) {
            Breed::Ghost  => 6,
            Breed::Goblin => 0,
            Breed::Ork    => 4,
            Breed::Troll  => 6,
        };
    }
}

final class Monster
{
    private Breed $breed;
    private int $hp;
    private int $def;

    private function __construct()
    {
    }

    public static function make(): self
    {
        $monster        = new self();
        $monster->breed = Breed::cases()[random_int(0, \count(Breed::cases()) - 1)];
        $monster->hp    = $monster->breed->hp();
        $monster->def   = $monster->breed->def();

        return $monster;
    }

    public static function fromState(string $breed, int $hp): self
    {
        $monster        = new self();
        $monster->breed = Breed::from($breed);
        $monster->hp    = $hp;
        $monster->def   = $monster->breed->def();

        return $monster;
    }

    public function state(): array
    {
        return [
            'breed' => $this->breed->value,
            'hp'    => $this->hp,
        ];
    }
}
