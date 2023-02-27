<?php

declare(strict_types=1);

namespace App\Game;

enum Breed: string
{
    case GHOST  = 'ghost';
    case GOBLIN = 'goblin';
    case ORK    = 'ork';
    case TROLL  = 'troll';

    public function hp(): int
    {
        return match ($this) {
            Breed::GHOST  => 8,
            Breed::GOBLIN => 12,
            Breed::ORK    => 10,
            Breed::TROLL  => 12,
        };
    }

    public function def(): int
    {
        return match ($this) {
            Breed::GHOST  => 6,
            Breed::GOBLIN => 0,
            Breed::ORK    => 4,
            Breed::TROLL  => 6,
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
