<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'location_id'; // sesuaikan jika di database primary key-nya 'location_id'

    protected $fillable = [
        'city',
        'province',
    ];
}