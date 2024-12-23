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

    public static function getLabels ():array
    {
        return [
            self::UNDERONEYEAR => 'Under One Year',
            self::ONEYEAR => 'One Year',
            self::TWOYEAR => 'Two Year',
            self::THREEYEAR => 'Three Year',
            self::FOURYEAR => 'Four Year',
        ];
    }
}
