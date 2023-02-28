<?php

declare(strict_types=1);

namespace App\Game\Exception;

final class CouldNotRest extends \Exception
{
    public static function alreadyRested(): self
    {
        return new self('Character already rested');
    }
}
