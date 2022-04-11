<?php

namespace App\Models;

use App\Traits\GetImageAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    use HasFactory;
    use GetImageAttributes;

    protected $guarded = [];


    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
