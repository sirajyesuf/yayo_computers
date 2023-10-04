<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'specifications' => 'array'
    ];


    public function purchases(){
        
        return $this->hasMany(Purchase::class);
    }

    public function sales(){
        
        return $this->hasMany(Sales::class);
    }

    public function lends(){
        return $this->hasMany(Lend::class);
    }
}
