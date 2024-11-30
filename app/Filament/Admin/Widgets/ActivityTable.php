<?php

namespace App\Filament\Admin\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Z3d0X\FilamentLogger\Resources\ActivityResource;
use Illuminate\Database\Eloquent\Model;

class ActivityTable extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(ActivityResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->actions([
                ViewAction::make(),
            ])
            ->columns([
                TextColumn::make('causer.name')
                    ->label(__('filament-logger::filament-logger.resource.label.user')),
                TextColumn::make('event')
                    ->label(__('filament-logger::filament-logger.resource.label.event')),
                TextColumn::make('subject_type')
                    ->label('Effected')
                    ->formatStateUsing(function ($state, Model $record) {
                        if (!$state) {
                            return '-';
                        }
                        return Str::of($state)->afterLast('\\')->headline() . ' (record) ' . $record->subject_id;
                    }),
                TextColumn::make('created_at')
                    ->label(__('filament-logger::filament-logger.resource.label.logged_at'))
                    ->dateTime(config('filament-logger.datetime_format', 'd/m/Y H:i:s'), config('app.timezone'))
                    ->sortable(),
            ]);
    }
}
