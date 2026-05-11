<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'category',
        'price',
        'description',
        'rating',
        'image_color',
        'status',
    ];

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }
}

