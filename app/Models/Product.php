<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Unit;
use App\Models\PurchaseSale;
use App\Models\Warehouse;
use App\Models\Transcation;
use App\Models\Warehouse_has_Product;



class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'rate',
        'category_id',
        'unit_id',
        'created_date'
    ];
    public function category() {
        return $this->belongsTo(Category::class);
}
public function unit()
{
 return $this->belongsTo(Unit::class);
}
public function warehouse_has_product()
{
    return  $this->hasMany(Warehouse_has_Product::class);
}
public function transcation()
{
    return $this->hasMany(Transcation::class);
}
public function PurchaseSale()
{
    return $this->hasMany(PurchaseSale::class);
}


}
