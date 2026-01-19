<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'customer_name',
        'car_name',
        'plate_number',
        'service_date',
        'status',
        'total_price'
    ];

    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }
}
