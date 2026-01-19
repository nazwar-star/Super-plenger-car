<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
        protected $fillable = [
        'car_id',
        'start_date',
        'end_date',
        'total_days',
        'total_price',
        'dp_amount',
        'payment_method',
        'payment_status',
        'status',
    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
