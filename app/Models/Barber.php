<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barber extends Model
{
    protected $table = 'barbers';

    protected $primaryKey = 'barber_id';

    protected $fillable = [
        'shop_id',
        'barber_name',
        'specialty',
        'photo',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'barber_id', 'barber_id');
    }
}
