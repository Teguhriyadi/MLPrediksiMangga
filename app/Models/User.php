<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuids, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_OPERATOR = 'operator';
    public const ROLE_PIMPINAN = 'pimpinan';
    public const ROLE_UPTD = 'uptd';

    protected $table = "users";

    protected $guarded = [""];

    protected $keyType = "string";

    public $incrementing = false;

    public $primaryKey = "id";

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public static function roleOptions(): array
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_OPERATOR => 'Operator',
            self::ROLE_PIMPINAN => 'Pimpinan',
            self::ROLE_UPTD => 'UPTD',
        ];
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
