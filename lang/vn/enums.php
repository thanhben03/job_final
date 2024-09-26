<?php


use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Enums\WorkTypeEnum;

return [
    GenderEnum::class => [
        GenderEnum::MALE => 'Nam',
        GenderEnum::FEMALE => 'Nữ',
        GenderEnum::NOT_REQUIRE => 'Không bắt buộc',
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
        QualificationEnum::UNIVERSITY => 'Đại học',
        QualificationEnum::COLLEGE => 'Cao đẳng',
    ],
    JobExpEnum::class => [
        JobExpEnum::UNDERONEYEAR => '< 1 Year',
        JobExpEnum::ONEYEAR => '1 Year',
        JobExpEnum::TWOYEAR => '2 Year',
        JobExpEnum::THREEYEAR => '3 Year',
        JobExpEnum::FOURYEAR => '4 Year',
    ]
];
