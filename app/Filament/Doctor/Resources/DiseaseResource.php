<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\DiseaseResource\Pages;
use App\Models\Disease;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class DiseaseResource extends Resource
{
    protected static ?string $model = Disease::class;

    protected static ?string $navigationGroup = 'Medical Record';

    protected static ?int $navigationSort = 3;

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
                            ->title('Disease deleted')
                            ->body('The Disease has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make()
                //         ->successNotification(
                //             Notification::make()
                //                 ->success()
                //                 ->title('All Diseases deleted')
                //                 ->body('All Diseases have been deleted successfully.'),
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
            'index' => Pages\ListDiseases::route('/'),
            'create' => Pages\CreateDisease::route('/create'),
            'view' => Pages\ViewDisease::route('/{record}'),
            'edit' => Pages\EditDisease::route('/{record}/edit'),
        ];
    }
}
