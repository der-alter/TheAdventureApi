<?php

declare(strict_types=1);

namespace App\Game\Exception;

final class CouldNotAttack extends \Exception
{
    public static function fromDeadMonster(): self
    {
        return new self('Monster is dead');
    }
}
