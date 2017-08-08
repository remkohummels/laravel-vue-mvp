<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class Hours extends Model
{
    protected $table = 'restaurant_hours';

    protected $fillable = [
        'restaurant_id',
        'dayofweek',
        'day_part',
        'day_part_order',
        'start_time',
        'end_time',
    ];

    // Return the restaurant
    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'restaurant_id', 'restaurant_id')->first();
    }

    // Return by day of the week
    public static function dayList($query, $day)
    {
        return $query->where('day', $day);
    }

    // Return by day part
    public static function dayPartList($query, $day_part)
    {
        return $query->where('day_part', $day_part);
    }
}
