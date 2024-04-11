<?php

namespace App\Models;
use App\Model\Transcation;
use App\Models\PurchaseSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'type',
        'created_date'
    ];
    public function transcation()
    {
        return $this->hasMany(Transcation::class);
    }
    public function PurchaseSale()
    {
        return $this->hasMany(PurchaseSale::class);
    }
}
