<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInput extends Model
{
    protected $table = 'sales_input';

    protected $fillable = [
        'restaurant_id',
        'date',
        'ignore',
        '0100',
        '0200',
        '0300',
        '0400',
        '0500',
        '0600',
        '0700',
        '0800',
        '0900',
        '1000',
        '1100',
        '1200',
        '1300',
        '1400',
        '1500',
        '1600',
        '1700',
        '1800',
        '1900',
        '2000',
        '2100',
        '2200',
        '2300',
        '2400',
    ];

    // Return the smg type
    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'restaurant_id', 'restaurant_id')->first();
    }

    // Return ignore list
    public static function ignoreStatusList($query, $status)
    {
        return $query->where('ignore', $status);
    }
}
