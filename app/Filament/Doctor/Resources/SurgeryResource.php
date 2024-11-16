<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\SurgeryResource\Pages;
use App\Models\Surgery;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class SurgeryResource extends Resource
{
    protected static ?string $model = Surgery::class; // هنا بيقلك ايه الموديل اللي هتتعاملي معاه

    protected static ?string $navigationGroup = 'Medical Record';  // هنا بحدد هما بينتموا لانهي جروب

    protected static ?int $navigationSort = 1; // ترتيب

    // بقله هاتلي عندك كام ريكورد
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
                            ->title('Surgery deleted')
                            ->body('The Surgery has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make()
                //         ->successNotification(
                //             Notification::make()
                //                 ->success()
                //                 ->title('All Surgeries deleted')
                //                 ->body('All Surgeries have been deleted successfully.'),
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
            'index' => Pages\ListSurgeries::route('/'),
            'create' => Pages\CreateSurgery::route('/create'),
            'view' => Pages\ViewSurgery::route('/{record}'),
            'edit' => Pages\EditSurgery::route('/{record}/edit'),
        ];
    }
}
