<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReceptionistResource\Pages;
use App\Filament\Admin\Resources\ReceptionistResource\RelationManagers;
use App\Models\Receptionist;
use App\Enums\GenderType;
use App\Enums\RoleType;
use Filament\Forms;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceptionistResource extends Resource
{
    protected static ?string $model = user::class;
    protected static ?string $navigationLabel = 'Receptionist Management'; //

    protected static ?string $navigationGroup = 'Receptionist';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $receptionist = User::role(RoleType::receptionist->value)->count();

        return $receptionist;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Section::make('receptionist Info')->schema([
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
                Select::make('gender')
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
                  ->role([RoleType::receptionist->value]);
          })
        
            ->actions([
              Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('receptionist deleted')
                            ->body('The receptionist has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
              Tables\Actions\BulkActionGroup::make([
                  Tables\Actions\DeleteBulkAction::make()
                      ->successNotification(
                          Notification::make()
                              ->success()
                              ->title('All records deleted')
                              ->body('All records have been deleted successfully.'),
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
            'index' => Pages\ListReceptionists::route('/'),
            'create' => Pages\CreateReceptionist::route('/create'),
            'view' => Pages\ViewReceptionist::route('/{record}'),
            'edit' => Pages\EditReceptionist::route('/{record}/edit'),
        ];
    }
}
