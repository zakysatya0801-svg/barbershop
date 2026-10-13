<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'customer_id',
        'go_barbershop_id',
        'service',
        'barber_id',
        'booking_date',
        'time_slot',
        'status',
    ];

    public function barber(): BelongsTo
    {
        return $this->belongsTo(Barber::class, 'barber_id', 'barber_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'booking_id', 'booking_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(CustomerRequest::class, 'booking_id', 'booking_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class, 'booking_id', 'booking_id');
    }

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }
}
