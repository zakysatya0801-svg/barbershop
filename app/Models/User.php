<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    // Menyesuaikan primary key dengan struktur tabel users.
    protected $primaryKey = 'user_id';

    // Menghubungkan User dengan data Admin untuk memperoleh role.
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'user_id');
    }

    // Mengatur konversi atribut model.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Memastikan pengguna memiliki role yang sesuai.
    // Status aktif belum diperiksa karena tabel users tidak memiliki kolom status.
    public function hasRole(string $role): bool
    {
        return $this->admin?->role === $role;
    }

    // Catatan: pemeriksaan status akun belum diterapkan karena kolom status
    // belum tersedia pada tabel users.
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
