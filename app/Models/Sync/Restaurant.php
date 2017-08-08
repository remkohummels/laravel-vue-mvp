<?php

namespace App\Models\Sync;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'sync_restaurants';

    protected $fillable = [
        'restaurant_id',
        'hierarchy_report',
        'hierarchy_column',
        'hierarchy_value',
    ];

    // Return the restaurant
    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'restaurant_id', 'restaurant_id')->first();
    }
}
