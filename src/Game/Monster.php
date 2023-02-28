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

    public function dice(): string
    {
        return match ($this) {
            Breed::GHOST  => '1D4',
            Breed::GOBLIN => '1D4 -1',
            Breed::ORK    => '1D6',
            Breed::TROLL  => '1D6',
        };
    }
}

final class Monster
{
    private Breed $breed;
    private int $hp;

    private function __construct()
    {
    }

    public static function make(): self
    {
        $monster        = new self();
        $monster->breed = Breed::cases()[random_int(0, \count(Breed::cases()) - 1)];
        $monster->hp    = $monster->breed->hp();

        return $monster;
    }

    public static function fromState(string $breed, int $hp): self
    {
        $monster        = new self();
        $monster->breed = Breed::from($breed);
        $monster->hp    = $hp;

        return $monster;
    }

    public function state(): array
    {
        return [
            'breed' => $this->breed->value,
            'hp'    => $this->hp,
        ];
    }

    public function roll(RollerInterface $roller): int
    {
        return $roller->roll($this->breed->dice());
    }

    public function takeDamage(int $damage): void
    {
        if ($damage > 0) {
            $this->hp -= $damage;
        }
    }

    public function alive(): bool
    {
        return $this->hp > 0;
    }

    public function bonus(Scene $scene) : int {
        return match ($scene) {
            Scene::GRASSLANDS => Breed::ORK === $this->breed ? 2 : 0,
            Scene::HILLS      => Breed::GHOST === $this->breed ? 2 : 0,
            Scene::FOREST     => Breed::GOBLIN === $this->breed ? 2 : 0,
            Scene::MOUNTAINS  => Breed::TROLL === $this->breed ? 2 : 0,
            default           => 0,
        };
    }
}
