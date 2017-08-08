<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemHistory extends Model
{
    protected $table = 'menu_items_history';

    // Return active menu item list
    public static function activeList($query, $status = 1)
    {
        return $query->where('active', $status);
    }

    // Return inactive menu item list
    public static function inactiveList($query, $status = 0)
    {
        return $query->where('active', $status);
    }

    // Return required menu item list
    public static function requiredStatusList($query, $status)
    {
        return $query->where('required', $status);
    }

    // Return menu item list by uom_type
    public static function uomTypeList($query, $type_name)
    {
        $type_id = UomType::where('name', $type_name)->first()->id;
        return $query->where('uom_type_id', $type_id);
    }

    // Return menu item list by serve_status
    public static function serveStatusList($query, $status_name)
    {
        $status_id = ServeStatus::where('name', $status_name)->first()->id;
        return $query->where('serve_status_id', $status_id);
    }

    // Return menu item list by sync_type
    public static function syncTypeList($query, $type_name)
    {
        $type_id = SyncType::where('name', $type_name)->first()->id;
        return $query->where('sync_type_id', $type_id);
    }
}
