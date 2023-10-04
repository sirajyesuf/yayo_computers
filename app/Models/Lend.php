<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lend extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function contact(){
        return $this->belongsTo(Contact::class);
    }
}
