<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\Models\Sync\Type as SyncType;
use App\Models\Restaurant\Type as RestaurantType;
use App\Models\HoursTemplate;
use App\Models\CurrencyFormat;

class Restaurant extends Authenticatable
{
    use Notifiable;

    protected $table = 'restaurants';

    protected $fillable = [
        'restaurant_id',
        'sync_type_id',
        'sync_date',
        'timezone',
        'hours_template_id',
        'currency_format_id',
        'country',
        'state',
        'city',
        'zip',
        'dma',
        'email',
        'restaurant_type_id',
        'password_required',
        'password',
        'password_reset',
        'notes',
    ];

    /**
     *  Over-ridden the {sendPasswordResetNotification} method from the "CanResetPassword" trait
     *  Remember to take care while upgrading laravel
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    // Return the sync type
    public function syncType()
    {
        return $this->hasOne('App\Models\Sync\Type', 'id', 'sync_type_id')->first();
    }

    // Return the hours template
    public function hoursTemplate()
    {
        return $this->hasOne('App\Models\HoursTemplate', 'id', 'hours_template_id')->first();
    }

    // Return the currency format
    public function currencyFormat()
    {
        return $this->hasOne('App\Models\CurrencyFormat', 'id', 'currency_format_id')->first();
    }

    // Return the day part list
    public function dayPartList()
    {
        return $this->hasMany('App\Models\DayPart', 'hours_template_id', 'hours_template_id')
                    ->orderBy('dayofweek', 'asc')
                    ->orderBy('day_part_order', 'asc')
                    ->get();
    }

    // Return the sync restaurant list
    public function syncRestaurantList()
    {
        return $this->hasMany('App\Models\Sync\Restaurant', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the sales input list
    public function salesInputList()
    {
        return $this->hasMany('App\Models\SalesInput', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the user list
    public function userList()
    {
        return $this->hasMany('App\Models\Relation\UserToRestaurant', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the menu item list
    public function menuItemList()
    {
        return $this->hasMany('App\Models\Relation\RestaurantToMenuItem', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the product_projection list
    public function productProjectionList()
    {
        return $this->hasMany('App\Models\ProductProjection', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the product_projection_override list
    public function productProjectionOverrideList()
    {
        return $this->hasMany('App\Models\ProductProjection\Override', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the product_mix list
    public function productMixList()
    {
        return $this->hasMany('App\Models\ProductMix', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the product_mix_defaults list
    public function productMixDefaultList()
    {
        return $this->hasMany('App\Models\ProductMixDefault', 'restaurant_id', 'restaurant_id')->get();
    }

    // Return the product_mix_modifier by 'restaurant_id'
    public function productMixModifier()
    {
        return $this->hasOne('App\Models\ProductMix\Modifier', 'restaurant_id', 'restaurant_id')->first();
    }

    // Return the restaurant_hours list
    public function restaurantHoursList()
    {
        return $this->hasMany('App\Models\Restaurant\Hours', 'restaurant_id', 'restaurant_id')
                    ->orderBy('dayofweek', 'asc')
                    ->orderBy('day_part_order', 'asc')
                    ->get();
    }

    // Return smg data by id
    public function smg()
    {
        return $this->hasMany('App\Models\Smg', 'store', 'restaurant_id')->get();
    }

    // Return restaurant list by sync_type
    public static function syncTypeList($query, $type_name)
    {
        $type_id = SyncType::where('name', $type_name)->first()->id;
        return $query->where('sync_type_id', $type_id);
    }

    // Return restaurant list by hours_template
    public static function hoursTemplateList($query, $template_name)
    {
        $template_id = HoursTemplate::where('template_name', $template_name)->first()->id;
        return $query->where('hours_template_id', $template_id);
    }

    // Return restaurant list by currency_format
    public static function currencyFormatList($query, $currency_format)
    {
        $currency_format_id = CurrencyFormat::where('name', $currency_format)->first()->id;
        return $query->where('currency_format_id', $currency_format_id);
    }

    // Return restaurant list by type
    public static function restaurantTypeList($query, $type_name)
    {
        $type_id = RestaurantType::where('name', $type_name)->first()->id;
        return $query->where('restaurant_type_id', $type_id);
    }

    // Return restaurant list by password_required
    public static function passwordRequiredStatusList($query, $status)
    {
        return $query->where('password_required', $status);
    }

    // Return restaurant list by password_reset
    public static function passwordResetStatusList($query, $status)
    {
        return $query->where('password_reset', $status);
    }
}
