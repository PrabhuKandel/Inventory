<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Office;
use App\Models\User;



class Office_has_User extends Model
{
    use HasFactory;
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    // Define a relationship to the Product model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
