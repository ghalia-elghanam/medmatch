<?php

namespace App\Filament\Doctor\Widgets;

use App\Models\User;
use App\Enums\RoleType;
use App\Models\Medicine;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Doctor\Resources\UserResource;
use Filament\Widgets\TableWidget as BaseWidget;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class PatientTableWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(UserResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('ssn')
                    ->searchable(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query
                    ->role([RoleType::patient->value]);
            })
            ->actions([
                EditAction::make()->form([
                    Select::make('medicines')
                        ->relationship('medicines', 'name')
                        ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->disabled(auth()->user()->hasRole(RoleType::radiologist->value))
                        ->hintAction(
                            fn(Select $component) => Action::make('select all')
                                ->action(fn() => $component->state(Medicine::pluck('id')->toArray()))
                        )
                        ->reactive()
                        ->afterStateUpdated(function ($state, $livewire) {
                            $patient = $livewire->record;
                            $conflicts = static::matchingAlgorithm($state, $patient);

                            if ($conflicts) {
                                $messages = $conflicts->pluck('msg')->unique()->implode(' & ');

                                Notification::make()
                                    ->title('Conflicts Detected')
                                    ->body("Reasons: $messages")
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
                ]),
            ]);
    }

    public static function matchingAlgorithm(array $selectedMedicineIds, User $patient)
    {
        $messages = collect();

        // 1. Check if the patient is allergic to any selected medicines
        $allergicMedicines = DB::table('user_allergy_medicine')
            ->where('user_id', $patient->id)
            ->whereIn('user_allergy_medicine_id', $selectedMedicineIds)
            ->get(['user_allergy_medicine_id']);
        if ($allergicMedicines->isNotEmpty()) {
            $medicineNames = DB::table('medicines')
                ->whereIn('id', $allergicMedicines->pluck('user_allergy_medicine_id'))
                ->pluck('name')
                ->map(fn($name) => json_decode($name, true)['en'] ?? 'Unknown') // استخراج الاسم باللغة الإنجليزية
                ->implode(', ');
            $messages->push((object) [
                'msg' => "The patient is allergic to these medicines: $medicineNames.",
            ]);
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
            $componentNames = DB::table('components')
                ->whereIn('id', $allergicComponents->pluck('user_allergy_component_id'))
                ->pluck('name')
                ->map(fn($name) => json_decode($name, true)['en'] ?? 'Unknown') // استخراج الاسم باللغة الإنجليزية
                ->implode(', ');
            $messages->push((object) [
                'msg' => "The patient is allergic to these components: $componentNames.",
            ]);
        }

        // 3. Check for restricted combinations between selected medicines
        $restrictions = DB::table('restricted_medicines')
            ->whereIn('medicine_id', $selectedMedicineIds)
            ->whereIn('restricted_medicine_id', $selectedMedicineIds)
            ->get(['medicine_id', 'restricted_medicine_id', 'msg']);
        if ($restrictions->isNotEmpty()) {
            $restrictionMessages = $restrictions->map(function ($restriction) {
                return (object) [
                    'msg' => $restriction->msg,
                ];
            });
            $messages = $messages->merge($restrictionMessages);
        }

        return $messages->isNotEmpty() ? $messages : null;
    }
}
