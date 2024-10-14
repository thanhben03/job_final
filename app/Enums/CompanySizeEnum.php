<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CompanySizeEnum extends Enum implements LocalizedEnum
{
    const ZERO_TWENTY = 1;
    const TWENTY_FIFTY = 2;
    const GREATER_THAN_FIFTY = 3;
}
