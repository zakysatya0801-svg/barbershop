<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model BarbershopQrToken
 *
 * Digunakan untuk mengelola token QR Code milik barbershop.
 * Token ini dapat digunakan untuk proses validasi akses,
 * identifikasi barbershop, dan pengecekan masa berlaku QR Code.
 */
class BarbershopQrToken extends Model
{
    /**
     * Kolom database yang boleh diisi secara mass assignment.
     *
     * Digunakan ketika membuat atau memperbarui token
     * menggunakan create() atau fill().
     */
    protected $fillable = [
        'go_barbershop_id',
        'token_hash',
        'status',
        'issued_at',
        'expires_at',
        'revoked_at',
    ];

    /**
     * Konversi tipe data kolom database secara otomatis.
     *
     * issued_at  : Waktu ketika token diterbitkan.
     * expires_at : Waktu kedaluwarsa token.
     * revoked_at : Waktu ketika token dicabut atau dinonaktifkan.
     *
     * Menggunakan immutable_datetime agar objek tanggal
     * tidak berubah ketika dilakukan manipulasi tanggal.
     */
    protected function casts(): array
    {
        return [
            'issued_at' => 'immutable_datetime',
            'expires_at' => 'immutable_datetime',
            'revoked_at' => 'immutable_datetime',
        ];
    }

    /**
     * Relasi ke tabel/model barbershop.
     *
     * Satu token QR Code hanya dimiliki oleh satu barbershop.
     *
     * Contoh penggunaan:
     * $token->barbershop;
     */
    public function barbershop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    /**
     * Memeriksa apakah token QR Code masih aktif dan valid.
     *
     * Syarat token aktif:
     * 1. Status token harus bernilai 'active'.
     * 2. Token belum pernah dicabut (revoked_at harus null).
     * 3. Token belum kedaluwarsa.
     * 4. Jika expires_at null, token tidak memiliki batas kedaluwarsa.
     *
     * Return:
     * true  = Token masih aktif dan dapat digunakan.
     * false = Token sudah tidak valid.
     *
     * Contoh penggunaan:
     * if ($token->isActive()) {
     *     // Token valid.
     * }
     */
    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->revoked_at === null
            && (
                $this->expires_at === null
                || $this->expires_at->isFuture()
            );
    }

    public function qrImagePath(): string
    {
        return 'barbershop-qr/'.$this->go_barbershop_id.'/'.$this->getKey().'.svg';
    }

    /**
     * Query Scope untuk mengambil token yang masih aktif.
     *
     * Digunakan untuk memfilter token aktif langsung
     * melalui query Eloquent.
     *
     * Syarat:
     * 1. Status harus 'active'.
     * 2. revoked_at harus null.
     * 3. expires_at harus null atau lebih besar dari waktu sekarang.
     *
     * Contoh penggunaan:
     * BarbershopQrToken::active()->get();
     *
     * Mengambil satu token aktif:
     * BarbershopQrToken::active()->first();
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active')
            ->whereNull('revoked_at')
            ->where(function (Builder $query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }
}
