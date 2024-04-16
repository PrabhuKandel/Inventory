<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\PurchaseSale;
use App\Models\Transcation;

class Office extends Model
{
    use HasFactory;
    protected $table = 'offices';
    
    protected $fillable = [
        'name',
        'address',
        'type',
        'created_date'
    ];
    
    public function warehouse()
    {
       return  $this->hasMany(Warehouse::class);
    }
    public function user()
    {
        return  $this->hasMany(User::class);
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
