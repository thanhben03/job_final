<?php


use App\Enums\CompanySizeEnum;
use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Enums\StatusCV;
use App\Enums\WorkTypeEnum;

return [
    GenderEnum::class => [
        GenderEnum::MALE => 'Male',
        GenderEnum::FEMALE => 'Female',
        GenderEnum::NOT_REQUIRE => 'Other',
    ],
    LevelEnum::class => [
        LevelEnum::INTERN => 'Intern',
        LevelEnum::FRESHER => 'Fresher',
        LevelEnum::JUNIOR => 'Junior',
        LevelEnum::MIDDLE => 'Middle',
        LevelEnum::SENIOR => 'Senior',
        LevelEnum::TECH_LEAD => 'Tech Lead',
    ],
    WorkTypeEnum::class => [
        WorkTypeEnum::PART_TIME => 'Part Time',
        WorkTypeEnum::FULL_TIME => 'Full Time',
    ],
    QualificationEnum::class => [
        QualificationEnum::UNIVERSITY => 'University',
        QualificationEnum::COLLEGE => 'College',
    ],
    StatusCV::class => [
        StatusCV::PENDING => 'Pending',
        StatusCV::SEEN => 'Seen',
        StatusCV::NOT_SUITABLE => 'Not Suitable',
        StatusCV::SUITABLE => 'Suitable',
    ],
    JobExpEnum::class => [
        JobExpEnum::UNDERONEYEAR => '< 1 Year',
        JobExpEnum::ONEYEAR => '1 Year',
        JobExpEnum::TWOYEAR => '2 Year',
        JobExpEnum::THREEYEAR => '3 Year',
        JobExpEnum::FOURYEAR => '4 Year',
    ],
    CompanySizeEnum::class => [
        CompanySizeEnum::ZERO_TWENTY => '0 - 20 employee',
        CompanySizeEnum::TWENTY_FIFTY => '20 - 50 employee',
        CompanySizeEnum::GREATER_THAN_FIFTY => '> 50 employee',
    ]
];
