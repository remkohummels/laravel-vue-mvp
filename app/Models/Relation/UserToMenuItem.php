<?php

namespace App\Models\Relation;

use Illuminate\Database\Eloquent\Model;

class UserToMenuItem extends Model
{
    protected $table = 'relations_user_to_menu_item';

    protected $fillable = [
        'user_id',
        'menu_item_id',
        'view',
        'edit',
        'assign_rest',
    ];

    // Return user
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->first();
    }

    // Return menu_item
    public function menuItem()
    {
        return $this->hasOne('App\Models\MenuItem', 'id', 'menu_item_id')->first();
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

    // Return assign_rest list
    public static function assignRestStatusList($query, $status)
    {
        return $query->where('assign_rest', $status);
    }
}
