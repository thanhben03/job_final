<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class QualificationEnum extends Enum implements LocalizedEnum
{
    const UNIVERSITY = 0;
    const COLLEGE = 1;
}
