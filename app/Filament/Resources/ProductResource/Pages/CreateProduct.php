<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Actions\Concerns\HasForm;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    // public static function form(Form $form): Form
    // {
    //     return $form->schema([
    //         Forms\Components\TextInput::make('name'),
    //         Forms\Components\KeyValue::make("spec")
    //     ]);
    // }
       
}
