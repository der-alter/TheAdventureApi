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
    private Monster $monster;

    public static function make(): self
    {
        $tile          = new self();
        $tile->scene   = Scene::cases()[random_int(0, \count(Scene::cases()) - 1)];
        $tile->monster = Monster::make();

        return $tile;
    }

    public static function fromState(string $scene, array $monster): self
    {
        $tile          = new self();
        $tile->scene   = Scene::from($scene);
        $tile->monster = Monster::fromState(...$monster);

        return $tile;
    }

    public function state(): array
    {
        return [
            'scene'   => $this->scene->value,
            'monster' => $this->monster->state(),
        ];
    }

    public function isMonsterAlive(): bool
    {
        return $this->monster->hp() > 0;
    }

    public function monsterAtk(RollerInterface $roller) : int {
        return $this->monster->attack($roller, $this->scene);
    }
}
