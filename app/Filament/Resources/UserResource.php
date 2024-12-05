<?php

namespace App\Filament\Resources;

use App\Enums\GenderEnum;
use App\Enums\RoleUserEnum;
use App\Filament\Actions\LockUserAction;
use App\Filament\Clusters\UserCluster;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Mail\BanUserMail;
use App\Mail\UnBanUserMail;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $cluster = UserCluster::class;
    protected static ?string $navigationLabel = 'User Management';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;


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
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('Ban User')
                        ->icon('heroicon-o-lock-closed')
                        ->label('Ban User')
                        ->visible(fn ($record) => !$record->ban)
                        ->form([
                            Forms\Components\Textarea::make('reason')
                            ->required()
                            ->maxLength(255),
                        ])
                        ->action(function (?Model $record, array $data) {
                            if ($record->ban) {
                                Notification::make()
                                    ->title('You have already ban this user')
                                    ->warning()
                                    ->send();
                            } else {
                                $dataMail = [
                                    'candidate_name' => $record->fullname,
                                    'reason' => $data['reason']
                                ];
                                $record->ban = 1;
                                $record->save();

                                Mail::to($record->email)->send(new BanUserMail($dataMail));

                                Notification::make()
                                    ->title('Success !')
                                    ->success()
                                    ->send();

                            }
                        }),
                    Tables\Actions\Action::make('Unlock User')
                        ->icon('heroicon-o-lock-open')
                        ->label('Unlock User')
                        ->visible(fn ($record) => $record->ban)
                        ->action(function (?Model $record, array $data) {
                            $record->ban = 0;
                            $record->save();
                            $dataMail = [
                                'candidate_name' => $record->fullname
                            ];
                            Mail::to($record->email)->send(new UnBanUserMail($dataMail));

                            Notification::make()
                                ->title('You have been unlocked for this user')
                                ->success()
                                ->send();
                        })
                ]),

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
