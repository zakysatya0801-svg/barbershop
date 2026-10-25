<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use LogicException;

class Booking extends Model
{
    use BelongsToTenant;

    protected $table = 'bookings';

    protected $primaryKey = 'booking_id';

    // Kolom yang boleh diisi melalui mass assignment.
    // service_id disesuaikan dengan nama kolom database.
    protected $fillable = [
        'customer_id',
        'service_id',
        'barber_id',
        'booking_date',
        'time_slot',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function (Booking $booking): void {
            if (! $booking->service()->exists() || ! $booking->barber()->exists()) {
                throw new LogicException(
                    'Layanan dan barber harus berasal dari barbershop aktif.'
                );
            }
        });
    }

    // Menghubungkan booking dengan barbershop terkait.
    public function goBarberShop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    // Menghubungkan booking dengan layanan yang dipilih.
    public function service(): BelongsTo
    {
        return $this->belongsTo(
            Service::class,
            'service_id',
            'service_id'
        );
    }

    // Menghubungkan booking dengan barber yang dipilih.
    public function barber(): BelongsTo
    {
        return $this->belongsTo(
            Barber::class,
            'barber_id',
            'barber_id'
        );
    }

    // Mengambil pembayaran yang terkait dengan booking.
    public function payments(): HasMany
    {
        return $this->hasMany(
            Payment::class,
            'booking_id',
            'booking_id'
        );
    }

    // Mengambil permintaan customer terkait booking.
    public function requests(): HasMany
    {
        return $this->hasMany(
            CustomerRequest::class,
            'booking_id',
            'booking_id'
        );
    }

    // Mengambil ulasan untuk booking ini.
    public function review(): HasOne
    {
        return $this->hasOne(
            Review::class,
            'booking_id',
            'booking_id'
        );
    }

    // Mengatur tipe data tanggal booking.
    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }
}
