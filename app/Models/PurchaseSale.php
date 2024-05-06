<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Office;
use App\Models\Contact;
use App\Models\Transcation;

class PurchaseSale extends Model
{
    use HasFactory;
    protected $table = 'purchase_sales';
    protected $fillable = [
        'type',
        'contact_id',
        'office_id',
    ];
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function transcation()
    {
        return $this->hasMany(Transcation::class, purchaseSale_id);
    }
}
