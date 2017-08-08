<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayPart extends Model
{
    protected $table = 'day_parts';

    protected $fillable = [
        'hours_template_id',
        'dayofweek',
        'day_part',
        'day_part_order',
        'start_time',
        'end_time',
        'shift',
    ];

    // Return the hours template
    public function hoursTemplate()
    {
        return $this->hasOne('App\Models\HoursTemplate', 'id', 'hours_template_id')->first();
    }

    // Return by day of week
    public static function dayofweekList($query, $dayofweek)
    {
        return $query->where('dayofweek', $dayofweek);
    }

    // Return by day part
    public static function dayPartList($query, $day_part)
    {
        return $query->where('day_part', $day_part);
    }
}
