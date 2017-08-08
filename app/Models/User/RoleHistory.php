<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class RoleHistory extends Model
{
    protected $table = 'user_roles_history';

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
