<?php

declare(strict_types=1);

namespace App\Game;

final class CoulNotAttack extends \Exception
{
    public static function noMonster(): self
    {
        return new self('No monster to attack');
    }
}
