<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barber extends Model
{
    use BelongsToTenant;

    protected $table = 'barbers';

    protected $primaryKey = 'barber_id';

    // Kolom yang boleh diisi melalui mass assignment.
    protected $fillable = [
        'barber_name',
        'specialty',
        'photo',
    ];

    // Menghubungkan barber dengan barbershop tempatnya bekerja.
    public function goBarberShop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    // Mengambil seluruh booking yang ditangani barber ini.
    public function bookings(): HasMany
    {
        return $this->hasMany(
            Booking::class,
            'barber_id',
            'barber_id'
        );
    }
}
