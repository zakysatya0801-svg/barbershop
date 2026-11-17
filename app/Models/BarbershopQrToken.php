<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model BarbershopQrToken
 *
 * Mengelola token QR Code milik barbershop.
 */
class BarbershopQrToken extends Model
{
    protected $fillable = [
        'go_barbershop_id',
        'token_hash',
        'status',
        'issued_at',
        'expires_at',
        'revoked_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'immutable_datetime',
            'expires_at' => 'immutable_datetime',
            'revoked_at' => 'immutable_datetime',
        ];
    }

    /**
     * Relasi ke barbershop.
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
     * Memeriksa apakah token masih aktif.
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

    /**
     * Lokasi penyimpanan gambar QR.
     */
    public function qrImagePath(): string
    {
        return 'barbershop-qr/'.$this->go_barbershop_id.'/'.$this->getKey().'.svg';
    }

    /**
     * Scope untuk mengambil token aktif.
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
