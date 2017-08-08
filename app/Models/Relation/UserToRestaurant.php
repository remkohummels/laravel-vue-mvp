<?php

namespace App\Models\Relation;

use Illuminate\Database\Eloquent\Model;

class UserToRestaurant extends Model
{
    protected $table = 'relations_user_to_restaurant';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'view',
        'edit',
        'make_inactive',
    ];

    // Return user
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->first();
    }

    // Return restaurant
    public function restaurant()
    {
        return $this->hasOne('App\Models\Restaurant', 'restaurant_id', 'restaurant_id')->first();
    }

    // Return view list
    public static function viewStatusList($query, $status)
    {
        return $query->where('view', $status);
    }

    // Return edit list
    public static function editStatusList($query, $status)
    {
        return $query->where('edit', $status);
    }

    // Return make_inactive list
    public static function makeInactiveStatusList($query, $status)
    {
        return $query->where('make_inactive', $status);
    }
}
