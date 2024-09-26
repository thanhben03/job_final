<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class JobExpEnum extends Enum implements LocalizedEnum
{
    const UNDERONEYEAR = 0;
    const ONEYEAR = 1;
    const TWOYEAR = 2;
    const THREEYEAR = 3;
    const FOURYEAR = 4;
}
