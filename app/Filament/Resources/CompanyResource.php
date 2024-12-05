<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Mail\BanUserMail;
use App\Mail\UnBanUserMail;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company_username')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company_address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('company_phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                // Forms\Components\FileUpload::make('company_avatar')
                //     ->avatar()
                //     ->visibility('public'), // Make files publicly accessible
                Forms\Components\TextInput::make('employee')
                    ->required()
                    ->numeric(),
                // Forms\Components\TextInput::make('banner')
                //     ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('introduce')

                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('facebook_link')
                    ->maxLength(255),
                Forms\Components\TextInput::make('twitter_link')
                    ->maxLength(255),
                Forms\Components\TextInput::make('instagram_link')
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('ban')
                    ->label('Status')
                    ->options([
                        0 => 'Active',
                        1 => 'Banned',
                    ])
                    ->sortable(),
                Tables\Columns\SelectColumn::make('is_active')
                    ->label('Active')
                    ->options([
                        0 => 'Peding',
                        1 => 'Active',
                    ])
                    ->sortable(),
                // ->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_phone')
                    ->searchable(),

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
                                    'candidate_name' => $record->company_name,
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
                                'candidate_name' => $record->company_name
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
