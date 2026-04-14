<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masukan extends Model
{
    protected $table = 'masukan'; // ⬅️ ini penting

    protected $fillable = [
        'nama',
        'email',
        'pesan',
        'rating'
    ];
}