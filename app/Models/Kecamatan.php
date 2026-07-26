<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = ['nama', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'kecamatan_id');
    }

    public function produksiMangga(): HasMany
    {
        return $this->hasMany(ProduksiMangga::class, 'kecamatan_id');
    }
}
