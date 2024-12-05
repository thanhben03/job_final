<?php

namespace App\Filament\Resources\ReportedCareerResource\Pages;

use App\Filament\Resources\ReportedCareerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportedCareer extends EditRecord
{
    protected static string $resource = ReportedCareerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
