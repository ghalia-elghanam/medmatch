<?php

namespace App\Filament\Admin\Resources;

use App\Models\User;
use Filament\Tables;
use App\Enums\RoleType;
use Filament\Forms\Form;
use App\Enums\GenderType;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Admin\Resources\DoctorResource\Pages;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class DoctorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Doctor Management';

    protected static ?string $navigationGroup = 'Doctor';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $doctor = User::role(RoleType::doctor->value)->count();

        return $doctor;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Doctor Info')->schema([
                    TextInput::make('name')
                        ->required()
                        ->string(),
                    TextInput::make('email')
                        ->required()
                        ->email(),
                    TextInput::make('ssn')
                        ->label('ssn')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->rule(['digits:10'])
                        ->numeric(),
                    Select::make('gender')
                        ->options([
                            'male' => GenderType::male->value,
                            'female' => GenderType::female->value,
                        ])
                        ->required(),
                    TextInput::make('address')
                        ->required()
                        ->string(),
                    TextInput::make('phone')
                        ->required()
                        ->string(),
                    DatePicker::make('birth')->format('d/m/Y')->displayFormat('d/m/Y'),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create')
                ])->columns(1),
                Section::make('Doctor Profile')->schema([
                    SpatieMediaLibraryFileUpload::make('profile')
                        ->image()
                        ->downloadable()
                        ->collection('profile'),
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
                TextColumn::make('gender'),
                TextColumn::make('address'),
                TextColumn::make('phone'),
                TextColumn::make('birth'),
                SpatieMediaLibraryImageColumn::make('profile')
                    ->circular()
                    ->collection('profile'),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->role([RoleType::doctor->value]);
            })
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Doctor deleted')
                            ->body('The Doctor has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('All Surgeries deleted')
                                ->body('All Surgeries have been deleted successfully.'),
                        ),
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'view' => Pages\ViewDoctor::route('/{record}'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}