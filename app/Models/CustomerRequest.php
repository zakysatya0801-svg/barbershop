<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerRequest extends Model
{
    use BelongsToTenant;

    protected $table = 'requests';

    protected $primaryKey = 'request_id';

    protected $fillable = [
        'booking_id',
        'customer_id',
        'massage',
        'status',
    ];

    protected function tenantRelationship(): ?string
    {
        return 'booking';
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
