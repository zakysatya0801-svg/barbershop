<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LogicException;

class Review extends Model
{
    use BelongsToTenant;

    protected $table = 'reviews';

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'costumer_id',
        'booking_id',
        'rating',
        'comment',
    ];

    protected static function booted(): void
    {
        static::saving(function (Review $review): void {
            if (! $review->booking()->exists()) {
                throw new LogicException(
                    'Ulasan harus terkait booking dari barbershop aktif.'
                );
            }
        });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }
}
