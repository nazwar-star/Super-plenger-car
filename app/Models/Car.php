<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
        protected $fillable = [
        'name',
        'brand',
        'year',
        'rental_price',
        'sale_price',
        'stock',
        'photo',
        'status',
    ];

    public function rentals()
{
    return $this->hasMany(Rental::class);
}
public function services()
{
    return $this->hasMany(Service::class);
}


}
