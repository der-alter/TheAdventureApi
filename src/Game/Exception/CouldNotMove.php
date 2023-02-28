<?php

declare(strict_types=1);

namespace App\Game\Exception;

final class CouldNotMove extends \Exception
{
    public static function fromSwamp(): self
    {
        return new self('Monster in swamp');
    }
}
