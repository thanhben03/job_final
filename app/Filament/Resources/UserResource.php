<?php

namespace App\Filament\Resources;

use App\Enums\GenderEnum;
use App\Enums\RoleUserEnum;
use App\Enums\WorkTypeEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('fullname')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birthday'),
                Forms\Components\TextInput::make('avatar')
                    ->maxLength(255)
                    ->default('default.jpg'),
                Forms\Components\TextInput::make('introduce')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price_per_hours')
                    ->numeric(),
                Forms\Components\TextInput::make('type_work')
                    ->numeric()
                    ->default(1),
                Forms\Components\Select::make('role')
                    ->options(RoleUserEnum::asSelectArray())
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->options(GenderEnum::asSelectArray())
                    ->default(0),
                Forms\Components\TextInput::make('province_id')
                    ->numeric(),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('main_cv')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fullname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->date()
                    ->sortable(),
                TextColumn::make('reported_count')
                    ->label('Reported Count')
                    ->counts('reported') // Use the counts method for relationship counting
                    ->sortable(),
                // Tables\Columns\TextColumn::make('avatar')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('price_per_hours')
                //     ->money('VND')
                //     ->sortable(),
                // Tables\Columns\SelectColumn::make('type_work')
                //     ->options(WorkTypeEnum::asSelectArray())
                //     ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\SelectColumn::make('gender')
                //     ->options(GenderEnum::asSelectArray())
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('province.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\SelectColumn::make('ban')
                    ->options([
                        0 => 'Active',
                        1 => 'Ban',
                    ])
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make()
                ])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
