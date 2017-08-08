<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMixDefault extends Model
{
    protected $table = 'product_mix_defaults';

    protected $fillable = [
        'restaurant_id',
        'date',
        'active',
        'menu_item_id',
        'unit',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    // Return the restaurant
    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'restaurant_id', 'restaurant_id')->first();
    }

    // Return the menu_item
    public function menuItem()
    {
        return $this->hasOne('App\Models\MenuItem', 'id', 'menu_item_id')->first();
    }

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
