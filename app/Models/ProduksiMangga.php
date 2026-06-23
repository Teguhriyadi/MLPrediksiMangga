<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProduksiMangga extends Model
{
    use HasUuids;

    protected $table = "produksi_mangga";

    protected $guarded = [""];

    protected $keyType = "string";

    public $incrementing = false;

    public $primaryKey = "id";

    public function varietasMangga(): BelongsTo
    {
        return $this->belongsTo(VarietasMangga::class, 'varietas_mangga_id');
    }
}
