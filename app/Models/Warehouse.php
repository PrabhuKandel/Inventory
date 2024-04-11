<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Office;
use App\Models\Product;
use App\Models\Transcation;
use App\Models\PurchaseSale;
use App\Models\Warehouse_has_Product;

class Warehouse extends Model
{
    use HasFactory;
    protected $table = 'warehouses';
    protected $fillable = [
        'name',
        'address',
        'office_id',
        'created_date'
    ];

    public function office()
    {
        return $this->hasMany(Warehouse::class);
    }
    public function product()
    {
        return $this->belongsToMany(Product::class,'warehouse_has_product')->withPivot('quantity');
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
