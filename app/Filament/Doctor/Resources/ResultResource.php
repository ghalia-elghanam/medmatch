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

class ResultResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Patient Result';

    protected static ?string $navigationGroup = 'Patient';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
      return 'matching';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->readOnly(),
                TextInput::make('ssn')->readOnly(),
            


                Select::make('user_allergy_medicine')
                ->relationship('allergies_medicine', 'name')
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                ->multiple()
                ->disabled( auth()->user()->hasRole(RoleType::doctor->value)),
            Select::make('user_allergy_component')
                ->relationship('allergies_component', 'name')
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                ->multiple()
                ->disabled( auth()->user()->hasRole(RoleType::doctor->value)),
                TextInput::make('result')
                    ->readOnly(! auth()->user()->hasRole(RoleType::doctor->value))
                    ->string(),
                Select::make('medicines')
                    ->relationship('medicines', 'name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->disabled(! auth()->user()->hasRole(RoleType::doctor->value))
                    
                    ->reactive()
                    ->afterStateUpdated(function ($state, $livewire) {
                        $patient = $livewire->record;
                        $conflicts = static::matchingAlgorithm($state, $patient);

                        if ($conflicts) {
                            $messages = $conflicts->pluck('msg')->unique()->implode(' & ');

                            Notification::make()
                                ->title('⚠️ Medication warning')
                                ->body("
                                <div>
                                    <p><strong>Reasons:</strong> $messages</p>
                                    <p>           Please review immediately.</p>
                                </div>
                            ")
                                ->warning()
                                ->persistent()
                                ->send();
                        }
                    }),
            ]);
    }

    public static function matchingAlgorithm(array $selectedMedicineIds, User $patient)
    {
        $messages = collect();

        // 1. Check if the patient is allergic to any selected medicines
        $allergicMedicines = DB::table('user_allergy_medicine')//table
            ->where('user_id', $patient->id)
            ->whereIn('user_allergy_medicine_id', $selectedMedicineIds)
            ->get(['user_allergy_medicine_id']);
        if ($allergicMedicines->isNotEmpty()) {
            // get name of medicine
            $medicineNames = DB::table('medicines')//table
                ->whereIn('id', $allergicMedicines->pluck('user_allergy_medicine_id'))
                ->pluck('name')//catch
                ->map(fn ($name) => json_decode($name, true)['en'] ?? 'Unknown') //only استخراج الاسم باللغة الإنجليزية
                ->implode(', ');
            $messages->push((object) [
                'msg' => "patient is allergic to these medicines: $medicineNames.",
            ]);
        }

        // 2. Check if the patient is allergic to any components of the selected medicines
        // بشوف مكونات الدواء اللي اخترته عشان اقدر اسرش عليها
        $medicineComponents = DB::table('medicine_component') //table
            ->whereIn('medicine_id', $selectedMedicineIds)
            ->pluck('component_id');
        $allergicComponents = DB::table('user_allergy_component')//table
            ->where('user_id', $patient->id)
            ->whereIn('user_allergy_component_id', $medicineComponents)
            ->get(['user_allergy_component_id']);
        if ($allergicComponents->isNotEmpty()) {
            $componentNames = DB::table('components')//table
                ->whereIn('id', $allergicComponents->pluck('user_allergy_component_id'))
                ->pluck('name')
                ->map(fn ($name) => json_decode($name, true)['en'] ?? 'Unknown') // استخراج الاسم باللغة الإنجليزية
                ->implode(', ');
            $messages->push((object) [
                'msg' => "patient is allergic to these components: $componentNames.",
            ]);
        }

        // 3. Check for restricted combinations between selected medicines
        $restrictions = DB::table('restricted_medicines')//table
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
