<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesResource\Pages;
use App\Filament\Resources\SalesResource\RelationManagers;
use App\Models\Sales;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Product;
use Illuminate\Support\Carbon;

class SalesResource extends Resource
{
    protected static ?string $model = Sales::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    protected  static function getName($product){

        $result = [];

        foreach ($product->specifications as $value) {
            $result[] = $value;
        }

        $output = implode(" x ", $result);

        return $product->name." ".$output;
    }

    public static function form(Form $form): Form
    {

        $options = Product::all()->map(function ($item) {
            return [
                'name' => self::getName($item),
                'id' => $item->id
            ];
        })->pluck('name','id');
        
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                ->label("Product")
                ->options($options)
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                    ->required(),
                    Forms\Components\KeyValue::make("specifications")
                    ->addActionLabel('Add More Spec')
                    ->keyLabel('spec')
                    ->keyPlaceholder('Processor')
                    ->valueLabel('value')
                    ->valuePlaceholder('core i7 9th generation')
                    ->reorderable()
                    ->required()
                ]),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                ->formatStateUsing(fn(string $state,Sales $record): string =>  self::getName($record->product))
                ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Date')
                ->date()
            ])
            ->filters([
                // Tables\Filters\SelectFilter::make('product_id')
                // ->options(Product::pluck('name','id'))
                // ->label('Product'),
                // Tables\Filters\SelectFilter::make('created_at')
                // ->options(
                //     Purchase::all()
                //     ->pluck('created_at')
                //     ->map(function ($date) {
                //         return Carbon::parse($date)->year;
                //     })
                //     ->unique()
                // )
                // ->default(Carbon::today()->year)
                // ->label('Year')
            ],layout: Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSales::route('/create'),
            'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }    
}
