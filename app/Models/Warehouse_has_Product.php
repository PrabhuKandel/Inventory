<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse_has_Product;

class Warehouse_has_Product extends Model
{
    use HasFactory;
    protected $table = 'warehouse_has__products';
    protected $fillable = [
      
        'quantity',
        'warehouse_id',
        'product_id',
    ];
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Define a relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
