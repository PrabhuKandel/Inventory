<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'units';
    protected $fillable = [
        'name',
        'description',
        'created_date'
    ];
    public function product()

    {
        return $this->hasMany(Product::class);
    }
}
