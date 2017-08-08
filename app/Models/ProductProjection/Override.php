<?php

namespace App\Models\ProductProjection;

use Illuminate\Database\Eloquent\Model;

class Override extends Model
{
    protected $table = 'product_projection_override';

    protected $fillable = [
        'restaurant_id',
        'menu_item_id',
        'value',
        'frequency',
        'date',
        'time',
    ];

    // Return the product projection
    public function productProjection()
    {
        return $this->hasMany('App\Models\ProductProjection', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the menu item
    public function menuItem()
    {
        return $this->hasOne('App\Models\MenuItem', 'id', 'menu_item_id')->first();
    }
}
