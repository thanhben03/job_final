<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class StatusCV extends Enum implements LocalizedEnum
{
    const PENDING = 0;
    const SEEN = 1;
    const NOT_SUITABLE = 2;
    const SUITABLE = 3;

    public static function getKeyFromDesc($type): mixed
    {
        $types = [
            'Pending' => self::PENDING,
            'Seen' => self::SEEN,
            'Not Suitable' => self::NOT_SUITABLE,
            'Suitable' => self::SUITABLE,
        ];

        // Kiểm tra nếu $type tồn tại trong enum, nếu không trả về null
        return $types[$type] ?? null;
    }
}
