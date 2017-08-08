<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sync\Type as SyncType;
use App\Models\Restaurant\Type as RestaurantType;
use App\Models\HoursTemplate;
use App\Models\CurrencyFormat;

class RestaurantHistory extends Model
{
    protected $table = 'restaurants_history';

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
