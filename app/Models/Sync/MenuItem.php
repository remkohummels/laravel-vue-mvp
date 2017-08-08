<?php

namespace App\Models\Sync;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'sync_menu_items';

    protected $fillable = [
        'menu_item_id',
        'hierarchy_report',
        'hierarchy_column',
        'hierarchy_value',
    ];

    // Return the menu_item
    public function menuItem()
    {
        return $this->hasOne('App\Models\MenuItem', 'id', 'menu_item_id')->first();
    }
}
