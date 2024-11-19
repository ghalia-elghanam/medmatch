<?php

namespace App\Filament\Admin\Resources;

use App\Enums\GenderType;
use App\Enums\RoleType;
use App\Filament\Admin\Resources\RadiologistResource\Pages;
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

class RadiologistResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Radiologist Management';

    protected static ?string $navigationGroup = 'Radiologist';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $radiologist = User::role(RoleType::radiologist->value)->count();

        return $radiologist;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Radiologist Info')->schema([
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
                        ->required(fn (string $context): bool => $context === 'create'),
                ])->columns(1),
                Section::make('Radiologist Profile')->schema([
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
                    ->role([RoleType::radiologist->value]);
            })
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Radiologist deleted')
                            ->body('The Radiologist has been deleted successfully.'),
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
            'index' => Pages\ListRadiologists::route('/'),
            'create' => Pages\CreateRadiologist::route('/create'),
            'view' => Pages\ViewRadiologist::route('/{record}'),
            'edit' => Pages\EditRadiologist::route('/{record}/edit'),
        ];
    }
}
