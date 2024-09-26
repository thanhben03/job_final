<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class WorkTypeEnum extends Enum implements LocalizedEnum
{
    const PART_TIME = 0;
    const FULL_TIME = 1;

    public static function getValue($type): mixed
    {
        $types = [
            'Full Time' => self::FULL_TIME,
            'Part Time' => self::PART_TIME,
        ];

        // Kiểm tra nếu $type tồn tại trong enum, nếu không trả về null
        return $types[$type] ?? null;
    }
}
