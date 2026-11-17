<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $table = 'customers';

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
    ];

    /**
     * Relasi Customer dengan User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Relasi Customer dengan Requests.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(
            CustomerRequest::class,
            'customer_id',
            'customer_id'
        );
    }
}
