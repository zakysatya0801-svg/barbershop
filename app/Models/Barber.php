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

    protected $fillable = [
        'go_barbershop_id',
        'barber_name',
        'specialty',
        'photo',
    ];

    // Relasi barber dengan barbershop
    public function goBarberShop(): BelongsTo
    {
        return $this->belongsTo(
            GoBarberShop::class,
            'go_barbershop_id',
            'go_barbershop_id'
        );
    }

    // Relasi booking barber
    public function bookings(): HasMany
    {
        return $this->hasMany(
            Booking::class,
            'barber_id',
            'barber_id'
        );
    }
}
