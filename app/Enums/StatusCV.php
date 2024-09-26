<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class StatusCV extends Enum implements LocalizedEnum
{
    const SUBMITTED = 0;
    const SEEN = 1;
    const NOT_SUITABLE = 2;
    const SUITABLE = 3;
}
