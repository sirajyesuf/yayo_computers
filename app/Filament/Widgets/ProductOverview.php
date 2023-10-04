<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Tables\Enums\FiltersLayout;

class ProductOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(ProductResource::getEloquentQuery())
            ->columns([
                
                Tables\Columns\TextColumn::make("name")
                ->url(fn (Product $record): string => ProductResource::getUrl('edit', ['record' => $record])),

                Tables\Columns\TextColumn::make("Number of Purchases")
                ->state(function (Product $record): string {
                    return $record->purchases()->sum("quantity");
                }),

                Tables\Columns\TextColumn::make("Number of Sales")
                ->state(function (Product $record): string {
                    return $record->sales()->sum("quantity");
                }),

                Tables\Columns\TextColumn::make("Number of Lend")
                ->state(function (Product $record): string {
                    return $record->lends()->sum("quantity");
                }),

                Tables\Columns\TextColumn::make("Stock")
                ->state(function (Product $record) {
                    $stock = ($record->purchases()->sum("quantity") - $record->sales()->sum("quantity")) - $record->lends()->sum("quantity");
                     
                    // if($stock > 10) return "<h5 style='background-color: green;'>".$stock."</h5>";
                    // if($stock < 10 and $stock >= 5) return "<h5 style='background-color: yellow;'>".$stock."</h5>";
                    // if($stock < 5) return "<h5 style='background-color: red;'>".$stock."</h5>";

                    return $stock;
                    
                })
                ->html()

            ])
            ->filters([
                Tables\Filters\Filter::make("created_at")
                ->form([
                    Flatpickr::make("date_range")
                    ->range()
                ])
                ],layout: FiltersLayout::AboveContent);
            
    }
}
