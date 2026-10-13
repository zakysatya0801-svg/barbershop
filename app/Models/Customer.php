<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'name',
        'phone',
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(CustomerRequest::class, 'customer_id', 'customer_id');
    }
}
