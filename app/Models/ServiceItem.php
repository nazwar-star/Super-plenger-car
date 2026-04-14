<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'category',
        'price',
        'stock',
        'image', // tambahkan ini
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
