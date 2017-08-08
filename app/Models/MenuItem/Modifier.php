<?php

namespace App\Models\MenuItem;

use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    protected $table = 'menu_items_modifier';

    protected $fillable = [
        'menu_item_id',
        'name',
        'active',
        'active_from',
        'active_to',
        'adjustment',
    ];

    // Return the menu item
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
