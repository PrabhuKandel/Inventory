<?php

namespace App\Models;

use  Illuminate\Database\Eloquent\Casts\Attribute;
use App\Model\Transcation;
use App\Models\PurchaseSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\traits\FormatAttribute;


class Contact extends Model
{
    use HasFactory, FormatAttribute;
    protected $fillable = [
        'name',
        'address',
        'type',
        'created_date'
    ];
    protected function name(): Attribute
    {
        return $this->formatAttribute();
    }
    protected function address(): Attribute
    {
        return $this->formatAttribute();
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
