<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use BelongsToTenant;

    protected $table = 'favorites';

    protected $primaryKey = 'favorite_id';

    protected $fillable = [
        'costumer_id',
    ];
}
