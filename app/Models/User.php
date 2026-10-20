<?php

namespace App\Models;

// Import class untuk relasi dan konfigurasi model Laravel.
// Mengaktifkan factory dan notifikasi pada model User.
/** @use HasFactory<\Database\Factories\UserFactory> */
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Menggunakan user_id sebagai primary key tabel users.
    protected $primaryKey = 'user_id';

    /**
     * Relasi ke tabel admins untuk mengambil role akun.
     */
    public function admin(): HasOne
    {
        // Menghubungkan users.user_id dengan admins.user_id.
        return $this->hasOne(Admin::class, 'user_id', 'user_id');
    }

    /**
     * Mengatur konversi tipe data atribut model.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
