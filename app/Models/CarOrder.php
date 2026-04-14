<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarOrder extends Model
{
     protected $fillable = [
        'user_id',
        'car_id',
        'type',
        'delivery_method',
        'payment_method',
        'bank_name',
        'ktp_photo',
        'payment_proof',
        'price',
        'status',
        'approved_by',
        'approved_at',
    ];

    // =====================
    // RELATIONS
    // =====================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
