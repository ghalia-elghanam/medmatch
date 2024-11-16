<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\AllergyResource\Pages;
use App\Models\Allergy;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class AllergyResource extends Resource
{
    protected static ?string $model = Allergy::class;

    protected static ?string $navigationGroup = 'Medical Record';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Translate::make()
                    ->schema([
                        TextInput::make('name')
                            // ->required()
                            ->string(),
                    ])
                    ->columnSpanFull()
                    ->locales(config('app.available_locale')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Allergy deleted')
                            ->body('The Allergy has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make()
                //         ->successNotification(
                //             Notification::make()
                //                 ->success()
                //                 ->title('All Allergies deleted')
                //                 ->body('All Allergies have been deleted successfully.'),
                //         ),
                // ]),
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
            'index' => Pages\ListAllergies::route('/'),
            'create' => Pages\CreateAllergy::route('/create'),
            'view' => Pages\ViewAllergy::route('/{record}'),
            'edit' => Pages\EditAllergy::route('/{record}/edit'),
        ];
    }
}
