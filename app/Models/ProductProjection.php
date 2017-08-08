<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProjection extends Model
{
    protected $table = 'product_projection';

    protected $fillable = [
        'restaurant_id',
        'opening_mod',
        'closing_mod',
        'day_projected',
        'day_expected',
        'day_difference',
        'product_projection_hours_template_id',
    ];

    // Return the menu item
    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'restaurant_id', 'restaurant_id')->first();
    }

    // Return the product projection hours template
    public function hoursTemplate()
    {
        return $this->hasOne('App\Models\ProductProjection\HoursTemplate', 'id', 'product_projection_hours_template_id')->first();
    }

    // Return the product projection schedule
    public function schedule()
    {
        return $this->hasMany('App\Models\ProductProjection\Schedule')->get();
    }

    // Return the product projection override
    public function override()
    {
        return $this->hasMany('App\Models\ProductProjection\Override')->get();
    }
}
