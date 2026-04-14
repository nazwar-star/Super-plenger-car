<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'year',
        'rental_price',
        'sale_price',
        'stock',
        'photo',
        'description',
        'youtube_url',
        'model_3d',
        'status',
    ];

    /**
     * RELATION: banyak option
     */
    public function options()
    {
        return $this->hasMany(CarOption::class);
    }
    public function orders()
    {
        return $this->hasMany(CarOrder::class);
    }


    /**
     * RELATION: banyak gambar (gallery)
     */
    public function images()
    {
        return $this->hasMany(CarImage::class);
    }
}
