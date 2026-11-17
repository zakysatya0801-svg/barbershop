<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'status',
    'email_verified_at',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * Relasi User dengan Admin.
     */
    public function admin(): HasOne
    {
        return $this->hasOne(
            Admin::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Relasi User dengan Customer.
     */
    public function customer(): HasOne
    {
        return $this->hasOne(
            Customer::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Relasi User dengan Owner melalui Admin.
     */
    public function owner(): HasOneThrough
    {
        return $this->hasOneThrough(
            Owner::class,
            Admin::class,
            'user_id',
            'admin_id',
            'user_id',
            'admin_id'
        );
    }

    /**
     * Pengaturan tipe data.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Memeriksa role pengguna.
     */
    public function hasRole(string $role): bool
    {
        $currentRole = $this->admin?->role ?? $this->role;

        return $currentRole === $role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isClient(): bool
    {
        return $this->hasRole('owner');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    /**
     * Memeriksa status akun.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
