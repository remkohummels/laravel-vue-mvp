<?php

namespace App\Models\ProductProjection;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'product_projection_schedule';

    protected $fillable = [
        'product_projection_id',
        'active',
        'menu_item_id',
        '0100',
        '0130',
        '0200',
        '0230',
        '0300',
        '0330',
        '0400',
        '0430',
        '0500',
        '0530',
        '0600',
        '0630',
        '0700',
        '0730',
        '0800',
        '0830',
        '0900',
        '0930',
        '1000',
        '1030',
        '1100',
        '1130',
        '1200',
        '1230',
        '1300',
        '1330',
        '1400',
        '1430',
        '1500',
        '1530',
        '1600',
        '1630',
        '1700',
        '1730',
        '1800',
        '1830',
        '1900',
        '1930',
        '2000',
        '2030',
        '2100',
        '2130',
        '2200',
        '2230',
        '2300',
        '2330',
        '2400',
        '2430',
    ];

    // Return the product projection
    public function productProjection()
    {
        return $this->hasOne('App\Models\ProductProjection', 'id', 'product_projection_id')->first();
    }

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
