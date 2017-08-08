<?php

namespace App\Models\ProductProjection;

use Illuminate\Database\Eloquent\Model;

class DayPart extends Model
{
    protected $table = 'product_projection_day_parts';

    protected $fillable = [
        'pp_hours_template_id',
        'order',
        'day',
        'day_part',
        'expected',
        'actual',
    ];

    // Return the product projection
    public function hoursTemplate()
    {
        return $this->hasOne('App\Models\ProductProjection\HoursTemplate', 'id', 'pp_hours_template_id')->first();
    }
}
