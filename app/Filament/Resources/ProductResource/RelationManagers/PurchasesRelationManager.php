<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Facades\Filament;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Support\Carbon;

class PurchasesRelationManager extends RelationManager
{
    protected static string $relationship = 'purchases';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('quantity')
                ->label("Number of Pieces")
                ->numeric()
                ->minValue(1)
                ->suffix("Pcs"),
                Forms\Components\DatePicker::make('created_at')
                ->label("Date")
                ->default(Carbon::today())
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('created_at')
            ])
            ->filters([
                Tables\Filters\Filter::make("created_at")
                ->form([
                    Flatpickr::make("date")
                    ->range()
                ]),
                Tables\Filters\Filter::make("lll")
                ->form([
                    Forms\Components\Select::make("Weekly")
                    ->options([
                        "7" => "Weekly",
                        "15" => "BiWeekly"
                    ])
                ])

            ],
            layout: FiltersLayout::AboveContent)
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
