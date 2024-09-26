<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class GenderEnum extends Enum implements LocalizedEnum
{
    const MALE = 0;
    const FEMALE = 1;
    const NOT_REQUIRE = 2;
}
