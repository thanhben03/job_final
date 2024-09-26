<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;


final class RoleUserEnum extends Enum implements LocalizedEnum
{
    const USER = 1;
    const COMPANY = 2;
    const ADMIN = 3;
    const FREELANCER = 4;

}
