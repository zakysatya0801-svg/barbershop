<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'owner_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
}
