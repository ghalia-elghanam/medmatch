<?php

namespace App\Filament\Doctor\Resources;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\MedicineResource\Pages;
use App\Models\Component;
use App\Models\Medicine;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static ?string $navigationGroup = 'Medicine Management';

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
                        TextInput::make('name')->string(),
                    ])
                    ->locales(config('app.available_locale')),
                Select::make('components')
                    ->relationship('components', 'name')
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
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),

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
                            ->title('Medicine deleted')
                            ->body('The Medicine has been deleted successfully.'),
                    ),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make()
                //         ->successNotification(
                //             Notification::make()
                //                 ->success()
                //                 ->title('All Medicines deleted')
                //                 ->body('All Medicines have been deleted successfully.'),
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
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'view' => Pages\ViewMedicine::route('/{record}'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}
