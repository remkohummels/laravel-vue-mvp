<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UomType;
use App\Models\ServeStatus;
use App\Models\Sync\Type as SyncType;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'name',
        'active',
        'required',
        'active_from',
        'active_to',
        'pos_name',
        'uom',
        'uom_qty_per',
        'uom_type_id',
        'serve_status_id',
        'serve_from',
        'serve_to',
        'sync_type_id',
        'sync_date',
        'projected_unit_sold_mon',
        'projected_unit_sold_tue',
        'projected_unit_sold_wed',
        'projected_unit_sold_thur',
        'projected_unit_sold_fri',
        'projected_unit_sold_sat',
        'projected_unit_sold_sun',
    ];

    // Return the uom type
    public function uomType()
    {
        return $this->hasOne('App\Models\UomType', 'id', 'uom_type_id')->first();
    }

    // Return the serve status
    public function serveStatus()
    {
        return $this->hasOne('App\Models\ServeStatus', 'id', 'serve_status_id')->first();
    }

    // Return the sync type
    public function syncType()
    {
        return $this->hasOne('App\Models\Sync\Type', 'id', 'sync_type_id')->first();
    }

    // Return the sync menu item list
    public function syncMenuItemList()
    {
        return $this->hasMany('App\Models\Sync\MenuItem')->get();
    }

    // Return the user list
    public function userList()
    {
        return $this->hasMany('App\Models\Relation\UserToMenuItem')->get();
    }

    // Return the restaurant list
    public function restaurantList()
    {
        return $this->hasMany('App\Models\Relation\RestaurantToMenuItem')->get();
    }

    // Return the product projection schedule list
    public function ppScheduleList()
    {
        return $this->hasMany('App\Models\ProductProjection\Schedule')->get();
    }

    // Return the product projection override list
    public function ppOverrideList()
    {
        return $this->hasMany('App\Models\ProductProjection\Override')->get();
    }

    // Return the product mix list
    public function productMixList()
    {
        return $this->hasMany('App\Models\ProductMix')->get();
    }

    // Return the menu item modifier list
    public function modifierList()
    {
        return $this->hasMany('App\Models\MenuItem\Modifier')->get();
    }

    // Return the menu item min_max list
    public function minMaxList()
    {
        return $this->hasMany('App\Models\MenuItem\MinMax')->get();
    }

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
