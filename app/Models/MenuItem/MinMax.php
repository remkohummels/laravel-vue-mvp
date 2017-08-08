<?php

namespace App\Models\MenuItem;

use Illuminate\Database\Eloquent\Model;

class MinMax extends Model
{
    protected $table = 'menu_items_min_max';

    protected $fillable = [
        'menu_item_id',
        'time',
        'min',
        'max',
    ];

    // Return the menu item
    public function menuItem()
    {
        return $this->hasOne('App\Models\MenuItem', 'id', 'menu_item_id')->first();
    }
}
