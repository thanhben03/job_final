<?php

// app/Filament/Actions/UpdateAuthorAction.php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms;
use App\Models\User;
use Filament\Forms\Form;

class LockUserAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'Update Author';
    }

    public function handle(array $data, User $record): void
    {
        // Thực thi hành động cập nhật
        dd($data, $record);
    }

    public function form(array|\Closure|null $form) : static
    {
        return $this->form(function (Forms\Form $form) {
            return $form->schema([
                Forms\Components\Textarea::make('reason')
                    ->label('Lý do khóa')
                    ->required(),
            ]);
        });
    }
}
