<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Type as UserType;
use App\Models\Sync\Type as SyncType;

class UserHistory extends Model
{
    protected $table = 'users_history';

    // Return the user full name
    public function getFullName()
    {
        if ($this->middle_name == null)
            return $this->first_name." ".$this->last_name;
        else
            return $this->first_name." ".$this->middle_name." ".$this->last_name;
    }

    // Return password resetted user list
    public static function passwordResetStatusList($query, $status)
    {
        return $query->where('password_reset', $status);
    }

    // Return active user list
    public static function activeList($query, $status = 1)
    {
        return $query->where('active', $status);
    }

    // Return inactive user list
    public static function inactiveList($query, $status = 0)
    {
        return $query->where('active', $status);
    }

    // Return user list by type
    public static function userTypeList($query, $type_name)
    {
        $type_id = UserType::where('name', $type_name)->first()->id;
        return $query->where('user_type_id', $type_id);
    }

    // Return user list by sync_type
    public static function syncTypeList($query, $type_name)
    {
        $type_id = SyncType::where('name', $type_name)->first()->id;
        return $query->where('sync_type_id', $flag);
    }
}
