<?php

namespace App\Models\Relation;

use Illuminate\Database\Eloquent\Model;

class RestaurantToMenuItem extends Model
{
    protected $table = 'relations_restaurant_to_menu_item';

    protected $fillable = [
        'restaurant_id',
        'menu_item_id',
        'associate',
    ];

    // Return restaurant
    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'restaurant_id', 'restaurant_id')->first();
    }

    // Return menu_item
    public function menuItem()
    {
        return $this->hasOne('App\Models\MenuItem', 'id', 'menu_item_id')->first();
    }

    // Return associate list
    public static function associateStatusList($query, $status)
    {
        return $query->where('associate', $status);
    }
}
