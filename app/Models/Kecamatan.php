<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = ['nama', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
