<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VarietasMangga extends Model
{
    use HasUuids;

    protected $table = 'varietas_mangga';

    protected $guarded = ['id'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function produksiMangga(): HasMany
    {
        return $this->hasMany(ProduksiMangga::class, 'varietas_mangga_id');
    }
}
