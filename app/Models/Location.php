<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $table = 'locations';

    protected $primaryKey = 'location_id';

    protected $fillable = [
        'city',
        'province',
    ];

    public function goBarberShops(): HasMany
    {
        return $this->hasMany(GoBarberShop::class, 'location_id', 'location_id');
    }
}
