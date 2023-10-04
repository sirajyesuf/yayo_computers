<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\LendsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\PurchasesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\SalesRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\KeyValue::make("specifications")
                ->addActionLabel('Add More Spec')
                ->keyLabel('spec')
                ->keyPlaceholder('Processor')
                ->valueLabel('value')
                ->valuePlaceholder('core i7 9th generation')
                ->reorderable()
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")
                ->formatStateUsing(function(string $state,Product $record): string {
                    $array = $record->specifications;
                    $result = [];
            
                    foreach ($array as $key => $value) {
                        $result[] = $value;
                    }
            
                    $output = implode(" x ", $result);
            
                    return $state." ".$output;
                }),
            ])
            ->filters([
                //
            ])
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
            PurchasesRelationManager::class,
            SalesRelationManager::class,
            LendsRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
