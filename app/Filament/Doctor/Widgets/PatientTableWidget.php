<?php

namespace App\Filament\Doctor\Widgets;

use App\Enums\RoleType;
use App\Filament\Doctor\Resources\UserResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

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
                ViewAction::make()->form([
                    TextInput::make('name'),
                    TextInput::make('email'),
                    TextInput::make('ssn'),
                    SpatieMediaLibraryFileUpload::make('profile')
                        ->downloadable()
                        ->collection('profile'),
                    SpatieMediaLibraryFileUpload::make('rays')
                        ->multiple()
                        ->downloadable()
                        ->collection('rays'),
                    Select::make('allergies_medicine')
                        ->relationship('allergies_medicine', 'name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                        ->multiple(),
                    Select::make('allergies_component')
                        ->relationship('allergies_component', 'name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                        ->multiple(),
                    TextInput::make('result'),
                    Select::make('medicines')
                        ->relationship('medicines', 'name')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                        ->multiple(),
                ]),
            ]);
    }
}
