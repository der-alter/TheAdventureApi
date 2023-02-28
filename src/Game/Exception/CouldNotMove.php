<?php

declare(strict_types=1);

namespace App\Game;

final class CoulNotMove extends \Exception
{
    public static function fromSwamp(): self
    {
        return new self('Monster in swamp');
    }
}
