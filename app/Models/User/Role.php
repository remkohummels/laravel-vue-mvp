<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'user_roles';

    protected $fillable = [
        'user_id',
        'manage_users',
        'manage_menu_items',
        'manage_translations',
    ];

    // Return the user
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->first();
    }

    // Return role list by manage_users
    public static function manageUserStatusList($query, $status)
    {
        return $query->where('manage_users', $status);
    }

    // Return role list by manage_menu_items
    public static function manageMenuItemStatusList($query, $status)
    {
        return $query->where('manage_menu_items', $status);
    }

    // Return role list by manage_translations
    public static function manageTranslationStatusList($query, $status)
    {
        return $query->where('manage_translations', $status);
    }
}
