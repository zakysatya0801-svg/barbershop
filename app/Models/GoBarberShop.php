<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GoBarberShop extends Model
{
    protected $table = 'go_barbershops';

    protected $primaryKey = 'go_barbershop_id';

    protected $fillable = [
        'owner_id',
        'location_id',
        'barbershop_name',
        'description',
        'photo',
        'open_time',
        'close_time',
    ];

    /**
     * Relasi QR Token.
     */
    public function qrTokens(): HasMany
    {
        return $this->hasMany(
            BarbershopQrToken::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    /**
     * Mengambil token aktif terbaru.
     */
    public function activeToken(): HasOne
    {
        return $this->hasOne(
            BarbershopQrToken::class,
            'go_barbershop_id',
            'go_barbershop_id'
        )->ofMany([
            'issued_at' => 'max',
            'id' => 'max',
        ], function (Builder $query): void {
            $query->where('status', 'active')
                ->whereNull('revoked_at')
                ->where(function (Builder $query): void {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                });
        });
    }

    /**
     * Relasi lokasi.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(
            Location::class,
            'location_id',
            'location_id'
        );
    }

    /**
     * Relasi skema komisi.
     */
    public function commissionSchemes(): HasMany
    {
        return $this->hasMany(
            CommissionScheme::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    /**
     * Relasi layanan.
     */
    public function services(): HasMany
    {
        return $this->hasMany(
            Service::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    /**
     * Relasi barber.
     */
    public function barbers(): HasMany
    {
        return $this->hasMany(
            Barber::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    /**
     * Relasi ulasan.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(
            Review::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    /**
     * Menentukan key untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'go_barbershop_id';
    }
}
