<?php

namespace App\Filament\Doctor\Resources;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\ResultResource\Pages;
use App\Models\Medicine;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class ResultResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Patient Result';

    protected static ?string $navigationGroup = 'Patient';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        $patient = User::role(RoleType::patient->value)->count();

        return $patient;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->readOnly(),
                TextInput::make('ssn')->readOnly(),
                TextInput::make('result')
                    ->readOnly(auth()->user()->hasRole(RoleType::radiologist->value))
                    ->string(),
                Select::make('medicines')
                    ->relationship('medicines', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->disabled(auth()->user()->hasRole(RoleType::radiologist->value))
                    ->hintAction(
                        fn (Select $component) => Action::make('select all')
                            ->action(fn () => $component->state(Medicine::pluck('id')->toArray()))
                    )
                    ->reactive()
                    ->afterStateUpdated(function ($state, $livewire) {
                        $patient = $livewire->record; // أو الطريقة المناسبة للحصول على المريض
                        $conflicts = static::matchingAlgorithm($state, $patient);
                        if ($conflicts) {
                            $messages = $conflicts->pluck('msg')->unique()->implode(', ');
                            Notification::make()
                                ->title('Conflict Detected')
                                ->body('Reason : '.$messages)
                                ->warning()
                                ->persistent()
                                ->send();
                        }
                    })
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
            ]);
    }

    public static function matchingAlgorithm(array $selectedMedicineIds, User $patient)
    {
        // 1. Check if the patient is allergic to any selected medicines
        $allergicMedicines = DB::table('user_allergy_medicine')
            ->where('user_id', $patient->id)
            ->whereIn('user_allergy_medicine_id', $selectedMedicineIds)
            ->get(['user_allergy_medicine_id']);

        if ($allergicMedicines->isNotEmpty()) {
            return collect(['msg' => 'Patient is allergic to one or more selected medicines.']);
        }

        // 2. Check if the patient is allergic to any components of the selected medicines
        $medicineComponents = DB::table('medicine_component')
            ->whereIn('medicine_id', $selectedMedicineIds)
            ->pluck('component_id');

        $allergicComponents = DB::table('user_allergy_component')
            ->where('user_id', $patient->id)
            ->whereIn('user_allergy_component_id', $medicineComponents)
            ->get(['user_allergy_component_id']);

        if ($allergicComponents->isNotEmpty()) {
            return collect(['msg' => 'Patient is allergic to one or more components of the selected medicines.']);
        }

        // 3. Check for restricted combinations between selected medicines
        $restrictions = DB::table('restricted_medicines')
            ->whereIn('medicine_id', $selectedMedicineIds)
            ->whereIn('restricted_medicine_id', $selectedMedicineIds)
            ->get(['medicine_id', 'restricted_medicine_id', 'msg']);

        if ($restrictions->isNotEmpty()) {
            return $restrictions; // Return the conflicting medicines and messages
        }

        return null; // No conflicts detected
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('ssn')->searchable(),
                TextColumn::make('result'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->role([RoleType::patient->value]);
            });
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
            'index' => Pages\ListResults::route('/'),
            'view' => Pages\ViewResult::route('/{record}'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }
}
