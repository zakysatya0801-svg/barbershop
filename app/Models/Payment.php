<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'payments_id';

    protected $fillable = [
        'booking_id',
        'ammound',
        'paymand_method',
        'paymand_status',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    protected function casts(): array
    {
        return [
            'ammound' => 'decimal:2',
        ];
    }
}
