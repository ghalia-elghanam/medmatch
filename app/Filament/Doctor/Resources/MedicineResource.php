<?php

namespace App\Filament\Doctor\Resources;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\MedicineResource\Pages;
use App\Models\Medicine;
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

    protected static ?string $navigationGroup = 'Medicine Management'; // group name

    protected static ?int $navigationSort = 2; // order resource

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
                    ->locales(config('app.available_locale')), // en ar
                Select::make('components')
                    ->relationship('components', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name) // return name
                    ->disabled(auth()->user()->hasRole(RoleType::radiologist->value)) // prevent radiologist
                    ->multiple() // الدواء الواحد يمكن ان يحتوي علي اكثر من مكون
                    ->preload() // حملهم قبل ما الصفحة تحمل كلها
                    ->searchable(), // بقدر اعمل سيرش فيها
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(), // column name

            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // view
                Tables\Actions\EditAction::make(), // edit
                Tables\Actions\DeleteAction::make() // delete
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Medicine deleted')
                            ->body('The Medicine has been deleted successfully.'),
                    ),
            ]);
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
