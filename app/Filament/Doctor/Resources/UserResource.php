<?php

namespace App\Filament\Doctor\Resources;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\UserResource\Pages;
use App\Models\Component;
use App\Models\Medicine;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Patient';// group name
    protected static ?string $navigationLabel = 'Patient Information';  // label
    protected static ?int $navigationSort = 3; // sort

    public static function getNavigationBadge(): ?string
    {
        $patient = User::role(RoleType::patient->value)->count(); // هاتلي عدد كل المرضي

        return $patient;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Patient Info')->schema([
                    TextInput::make('name')
                        ->readOnly(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->required()
                        ->string(),
                    TextInput::make('email')
                        ->readOnly(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->required()
                        ->email(),
                    TextInput::make('ssn')
                        ->readOnly(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->label('ssn')
                        ->required()
                        ->unique(ignoreRecord: true),
                ])->columns(1),
                Section::make('Patient Profile')->schema([
                    SpatieMediaLibraryFileUpload::make('profile')
                        ->disabled(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->image()
                        ->downloadable()
                        ->collection('profile'),
                ])->columns(1),
                Section::make('Patient Rays')->schema([
                    SpatieMediaLibraryFileUpload::make('rays')
                        ->multiple()
                        ->downloadable()
                        ->collection('rays')
                        ->disabled(auth()->user()->hasRole(RoleType::doctor->value)),
                ])->columns(1),
                Section::make('Patient History')->schema([
                    Select::make('allergies_medicine')
                        ->relationship('allergies_medicine', 'name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                        ->disabled(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->hintAction(
                            fn (Select $component) => Action::make('select all')
                                ->action(fn () => $component->state(Medicine::pluck('id')->toArray()))
                        )
                        ->createOptionForm([
                            Translate::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->string(),
                                ])
                                ->columnSpanFull()
                                ->locales(config('app.available_locale')),
                        ]),
                    Select::make('allergies_component')
                        ->relationship('allergies_component', 'name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                        ->disabled(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->hintAction(
                            fn (Select $component) => Action::make('select all')
                                ->action(fn () => $component->state(Component::pluck('id')->toArray()))
                        )
                        ->createOptionForm([
                            Translate::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->string(),
                                ])
                                ->columnSpanFull()
                                ->locales(config('app.available_locale')),
                        ]),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('ssn')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('profile')
                    ->circular()
                    ->collection('profile'),

            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->role([RoleType::patient->value]);
            })
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('User deleted')
                            ->body('The User has been deleted successfully.'),
                    ),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
