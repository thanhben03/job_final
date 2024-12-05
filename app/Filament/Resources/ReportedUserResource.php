<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\UserCluster;
use App\Filament\Resources\ReportedUserResource\Pages;
use App\Filament\Resources\ReportedUserResource\RelationManagers;
use App\Models\ReportedUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportedUserResource extends Resource
{
    protected static ?string $model = ReportedUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Report Management';
    protected static ?string $cluster = UserCluster::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('report_content')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.company_name')
                    ->label('Sender')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.fullname')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('report_content')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        0 => 'Cancel',
                        1 => 'Approved',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('images')
                    ->action(fn (ReportedUser $record) => $record->images())
                    ->modalContent(fn (ReportedUser  $record): View => view(
                        'filament.images_report_user',
                        ['record' => $record],
                    ))
                    ->modalSubmitAction(false)
                ,
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportedUsers::route('/'),
            'create' => Pages\CreateReportedUser::route('/create'),
            'edit' => Pages\EditReportedUser::route('/{record}/edit'),
        ];
    }
}
