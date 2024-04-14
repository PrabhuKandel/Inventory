<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Office;
use App\Models\Contact;
use App\Models\PurchaseSale;


class Transcation extends Model
{
    use HasFactory;
    protected $table = 'transcations';
    protected $fillable = [
        'type',
        'quantity',
        'amount',
        'warehouse_id',
        'contact_id',
        'product_id',
        'user_id',
        'office_id',
        'created_date',
        'purchaseSale_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
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
    public function PurchaseSale()
    {
        return $this->belongsTo(PurchaseSale::class,purchaseSale_id);
    }
}
