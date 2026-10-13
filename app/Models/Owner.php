<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    protected $table = 'owners';

    protected $primaryKey = 'owner_id';

    protected $fillable = [
        'nama_owners',
        'email',
        'phone',
        'admin_id',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function goBarberShops(): HasMany
    {
        return $this->hasMany(GoBarberShop::class, 'owner_id', 'owner_id');
    }
}
