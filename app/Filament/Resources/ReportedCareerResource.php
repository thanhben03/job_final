<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\CareerCluster;
use App\Filament\Resources\ReportedCareerResource\Pages;
use App\Filament\Resources\ReportedCareerResource\RelationManagers;
use App\Models\ReportedCareer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportedCareerResource extends Resource
{
    protected static ?string $model = ReportedCareer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Report Management';
    protected static ?string $cluster = CareerCluster::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('career_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('report_content')
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('career.title')

                    ->sortable(),
                Tables\Columns\TextColumn::make('report_content')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.fullname')
                    ->label('Sender')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        0 => 'Cancel',
                        1 => 'Approve'
                    ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('images')
                    ->action(fn (ReportedCareer $record) => $record->images())
                    ->modalContent(fn (ReportedCareer  $record): View => view(
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
            'index' => Pages\ListReportedCareers::route('/'),
            'create' => Pages\CreateReportedCareer::route('/create'),
            'edit' => Pages\EditReportedCareer::route('/{record}/edit'),
        ];
    }
}
