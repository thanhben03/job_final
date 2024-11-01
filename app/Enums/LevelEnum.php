<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class LevelEnum extends Enum implements LocalizedEnum
{
    const INTERN = 0;
    const FRESHER = 1;
    const JUNIOR = 2;
    const MIDDLE = 3;
    const SENIOR = 4;
    const TECH_LEAD = 5;

    public static function getLabels(): array
    {
        return [
            self::INTERN => 'Intern',
            self::FRESHER => 'Fresher',
            self::JUNIOR => 'Junior',
            self::MIDDLE => 'Middle',
            self::SENIOR => 'Senior',
            self::TECH_LEAD => 'Tech Lead',
        ];
    }
}
