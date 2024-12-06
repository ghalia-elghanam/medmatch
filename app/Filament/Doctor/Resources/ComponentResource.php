<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\ComponentResource\Pages;
use App\Models\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class ComponentResource extends Resource
{
    protected static ?string $model = Component::class;

    protected static ?string $navigationGroup = 'Medicine Management'; // group name

    protected static ?int $navigationSort = 1; // order resource

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count(); // number of records
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Translate::make() // translated
                    ->schema([
                        TextInput::make('name')->string(), // name feild
                    ])
                    ->locales(config('app.available_locale')), // ar en
            ])->columns(1); // take full width
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(), // name column
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // view
                Tables\Actions\EditAction::make(), // edit
                Tables\Actions\DeleteAction::make() // delete
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Component deleted')
                            ->body('The Component has been deleted successfully.'),
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComponents::route('/'),
            'create' => Pages\CreateComponent::route('/create'),
            'view' => Pages\ViewComponent::route('/{record}'),
            'edit' => Pages\EditComponent::route('/{record}/edit'),
        ];
    }
}
