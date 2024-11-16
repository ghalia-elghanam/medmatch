<?php

namespace App\Filament\Doctor\Widgets;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\UserResource;
use App\Models\Medicine;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class PatientTableWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    // protected int|string|array $columnSpan = 'full';

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
                        ->afterStateUpdated(function ($state) {
                            $conflicts = static::matchingAlgorithm($state);
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
                ]),
            ]);
    }

    // matching algorithm
    public static function matchingAlgorithm(array $selectedMedicineIds)
    {
        $restrictions = DB::table('restricted_medicines')
            ->whereIn('medicine_id', $selectedMedicineIds)
            ->whereIn('restricted_medicine_id', $selectedMedicineIds)
            ->get(['medicine_id', 'restricted_medicine_id', 'msg']);
        if ($restrictions->isNotEmpty()) {
            return $restrictions; // result of medicine
        }
        // get component id
        $components = DB::table('medicine_component')
            ->whereIn('medicine_id', $selectedMedicineIds)
            ->pluck('component_id');
        // search by component id in restricted_components
        $conflicts = DB::table('restricted_components')
            ->whereIn('component_id', $components)
            ->whereIn('restricted_component_id', $components)
            ->get(['component_id', 'restricted_component_id', 'msg']);
        if ($conflicts->isNotEmpty()) {
            return $conflicts; // result of componet
        }

        return null; // no matching algorithm الدواء دا سليم
    }
}
