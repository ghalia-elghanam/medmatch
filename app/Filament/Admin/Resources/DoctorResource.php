<?php

namespace App\Filament\Admin\Resources;

use App\Enums\GenderType;
use App\Enums\RoleType;
use App\Filament\Admin\Resources\DoctorResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
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
use Illuminate\Support\Facades\Hash;

class DoctorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Doctor Management'; // label

    protected static ?string $navigationGroup = 'Doctor'; // group name

    protected static ?int $navigationSort = 1; // sort order

    public static function getNavigationBadge(): ?string
    {
        $doctor = User::role(RoleType::doctor->value)->count(); // return number of doctors

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
                        ->unique(ignoreRecord: true),
                    Select::make('gender') // name => show to user & value => go to database
                        ->options([
                            GenderType::male->value => GenderType::male->name,
                            GenderType::female->value => GenderType::female->name,
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
                        ->password() // show it as a (*)
                        ->revealable() // eye
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create'),
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
                    ->searchable(), // search by ssn
                TextColumn::make('gender'),
                TextColumn::make('address'),
                TextColumn::make('phone'),
                TextColumn::make('birth'),
                SpatieMediaLibraryImageColumn::make('profile')
                    // ->circular() // circle picture
                    ->collection('profile'),
            ])
            // filter by type
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->role([RoleType::doctor->value]);
            })
            ->actions([
                // 3 actions for each record
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
                // delete all
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('All Doctors deleted')
                                ->body('All Doctors have been deleted successfully.'),
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