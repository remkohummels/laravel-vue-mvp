<?php

namespace App\Models\ProductProjection;

use Illuminate\Database\Eloquent\Model;

class ScheduleHistory extends Model
{
    protected $table = 'product_projection_schedule_history';

    // Return active list
    public static function activeList($query, $status = 1)
    {
        return $query->where('active', $status);
    }

    // Return inactive list
    public static function inactiveList($query, $status = 0)
    {
        return $query->where('active', $status);
    }
}
