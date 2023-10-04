<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Contact;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;

class LendsRelationManager extends RelationManager
{
    protected static string $relationship = 'lends';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('contact_id')
                    ->label("Contact")
                    ->options(Contact::pluck("name","id"))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make("quantity")
                ->numeric()
                ->minValue(1)
                ->required()
                ->default(1),
                Flatpickr::make("due_date")
                ]);
    }

// 0927845316
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.id')
            ->columns([
                Tables\Columns\TextColumn::make('contact.name')
                ->label("Name"),
                Tables\Columns\TextColumn::make('contact.phone_number')
                ->label("PhoneNumber"),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('due_date'),
            ])
            ->filters([
                //
            ])
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
