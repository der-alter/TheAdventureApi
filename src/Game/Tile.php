<?php

declare(strict_types=1);

namespace App\Game;

enum Scene: string
{
    case GRASSLANDS = 'grasslands';
    case HILLS      = 'hills';
    case FOREST     = 'forest';
    case MOUNTAINS  = 'mountains';
    case DESERT     = 'desert';
    case SWAMP      = 'swamp';
}

final class Tile
{
    private Scene $scene;

    public static function make(): self
    {
        $tile        = new self();
        $tile->scene = Scene::cases()[random_int(0, \count(Scene::cases()) - 1)];

        return $tile;
    }

    public static function fromState(string $scene): self
    {
        $tile        = new self();
        $tile->scene = Scene::from($scene);

        return $tile;
    }

    public function state(): array
    {
        return [
            'scene' => $this->scene->value,
        ];
    }

    public function scene(): Scene
    {
        return $this->scene;
    }

    public function damage(): int
    {
        return match ($this->scene) {
            Scene::DESERT => 1,
            default       => 0
        };
    }
}
