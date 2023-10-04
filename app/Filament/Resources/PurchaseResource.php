<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

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
                ->formatStateUsing(fn(string $state,Purchase $record): string =>  self::getName($record->product)),
                Tables\Columns\TextColumn::make('quantity'),
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }    
}
