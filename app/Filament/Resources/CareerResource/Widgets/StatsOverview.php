<?php

namespace App\Filament\Resources\CareerResource\Widgets;

use App\Models\Career;
use App\Models\Company;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('User Count', User::count())
                ->description('Số người dùng')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Career Count', Career::count())
                ->description('Công việc đã tạo'),
            Stat::make('Company', Company::count())
                ->description('Công ty tin dùng'),
        ];
    }
}
