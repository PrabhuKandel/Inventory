<?php

namespace App\traits;

use  Illuminate\Database\Eloquent\Casts\Attribute;

trait FormatAttribute
{
  protected function formatAttribute(): Attribute
  {
    return Attribute::make(
      // will be automatically called when getting name 
      get: fn (string $value) => ucfirst(strtolower($value)),
      set: fn (string $value) => strtolower($value),
    );
  }
}
