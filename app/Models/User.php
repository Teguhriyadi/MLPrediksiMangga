<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasUuids;

    protected $table = "users";

    protected $guarded = [""];

    protected $keyType = "string";

    public $incrementing = false;

    public $primaryKey = "id";
}
