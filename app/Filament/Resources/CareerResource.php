<?php

namespace App\Filament\Resources;

use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Enums\WorkTypeEnum;
use App\Filament\Clusters\CareerCluster;
use App\Filament\Resources\CareerResource\Pages;
use App\Filament\Resources\CareerResource\RelationManagers;
use App\Models\Career;
use App\Models\Category;
use App\Models\Company;
use App\Models\District;
use App\Models\Province;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpParser\Builder;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $cluster = CareerCluster::class;
    protected static ?string $navigationLabel = 'Career Management';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin cơ bản')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->options(Category::all()->pluck('name', 'id'))
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->readOnly(),
                        Forms\Components\TextInput::make('min_salary')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('max_salary')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('experience')
                            ->options(JobExpEnum::asSelectArray())
                            ->required(),
                        Forms\Components\Select::make('level')
                            ->options(LevelEnum::asSelectArray())
                            ->required(),
                        Forms\Components\TextInput::make('employee')
                            ->required()
                            ->numeric(),
                        Forms\Components\Select::make('gender')
                            ->options(GenderEnum::asSelectArray())
                            ->required(),
                        Forms\Components\Select::make('working_time')
                            ->options(WorkTypeEnum::asSelectArray())
                            ->required(),
                        Forms\Components\TextInput::make('from_time')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('to_time')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('expiration_day')
                            ->required(),
                        Forms\Components\Select::make('qualification')
                            ->options(QualificationEnum::asSelectArray())
                            ->required(),
                        Forms\Components\Select::make('company_id')
                            ->options(Company::all()->pluck('company_name', 'id'))
                            ->required(),
                        Forms\Components\Select::make('province_id')
                            ->options(Province::all()->pluck('name', 'code'))
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('district_id')
                            ->label('District')
                            ->options(fn(Get $get): Collection => District::query()
                                ->where('province_code', $get('province_id'))
                                ->pluck('name', 'code'))
                            ->required(),
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('Thống tin cụ thể')
                    ->relationship('detail')
                    ->schema([
                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Description'),
                        Forms\Components\MarkdownEditor::make('requirement')
                            ->label('Require'),
                        Forms\Components\MarkdownEditor::make('benefit')
                            ->label('Benefit'),
                        Forms\Components\MarkdownEditor::make('key_responsibilities')
                            ->label('Key Responsibilities'),
                    ])
                    ->collapsible()
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Published')
                    ->options([0 => 'Pending', 1 => 'Active', 2 => 'Decline'])
                    ->sortable(),
                Tables\Columns\SelectColumn::make('deleted_at')
                    ->label('Trashed')
                    ->options([
                        null => 'Restored',
                        1 => 'Trashed',
                    ])
                    ->extraAttributes(['style' => 'width: max-content'])
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state === null) {
                            // Logic để khôi phục
                            $record->restore(); // Nếu model có SoftDeletes
                        } else {
                            // Logic để xóa mềm và cập nhật ngày giờ
                            $record->update(['deleted_at' => 1]);
                        }
                    })
                    ,
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->formatStateUsing(fn($state) => LevelEnum::getLabels()[$state] ?? 'Unknown') // Format based on enum values
                    ->sortable(),
                Tables\Columns\TextColumn::make('employee')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('expiration_day')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.company_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('province.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
//                TextColumn::make('spam_count')
//                    ->label('Reported Count')
//                    ->counts('spam') // Use the counts method for relationship counting
//                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive'
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                ->options(fn(Get $get): Collection => Category::query()->pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('province_id')
                ->label('Province')
                ->options(fn(Get $get): Collection => Province::query()->pluck('name', 'code')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->button()
                ->label('Actions')
                ->color('info'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('decline_job')
                        ->label('Decline')
                        ->form([
                            Forms\Components\Textarea::make('reason')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->action(function (?Model $record, array $data) {
                            $record->status = 2;
                            $record->reason = $data['reason'];
                            $record->save();

                            Notification::make()
                                ->title('Success !')
                                ->success()
                                ->send();
                        })
                    ,
                    Tables\Actions\Action::make('approve_job')
                        ->label('Approve')
                        ->action(function (?Model $record, array $data) {
                            $record->status = 1;
                            $record->save();
                            Notification::make()
                                ->title('Success !')
                                ->success()
                                ->send();
                        })
                    ,
                    Tables\Actions\Action::make('pending_job')
                        ->label('Pending')
                        ->action(function (?Model $record, array $data) {
                            $record->status = 0;
                            $record->save();
                            Notification::make()
                                ->title('Success !')
                                ->success()
                                ->send();
                        })
                    ,
                ])
                ->button()
                ->color('success')
                ->label('Approve')
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
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareer::route('/create'),
            'edit' => Pages\EditCareer::route('/{record}/edit'),
        ];
    }
}
