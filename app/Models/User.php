<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\Models\User\Type as UserType;
use App\Models\Sync\Type as SyncType;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'password_reset',
        'active',
        'user_type_id',
        'phone',
        'sync_type_id',
        'sync_date',
        'notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token'
    ];

    /**
     *  Over-ridden the {sendPasswordResetNotification} method from the "CanResetPassword" trait
     *  Remember to take care while upgrading laravel
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    // Return the user type
    public function userType()
    {
        return $this->hasOne('App\Models\User\Type', 'id', 'user_type_id')->first();
    }

    // Return the sync type
    public function syncType()
    {
        return $this->hasOne('App\Models\Sync\Type', 'id', 'sync_type_id')->first();
    }

    // Return the role of this user
    public function role()
    {
        return $this->hasOne('App\Models\User\Role')->first();
    }

    // Return the sync user list
    public function syncUserList()
    {
        return $this->hasMany('App\Models\Sync\User')->get();
    }

    // Return the restaurant list
    public function restaurantList()
    {
        return $this->hasMany('App\Models\Relation\UserToRestaurant')->get();
    }

    // Return the menu item list
    public function menuItemList()
    {
        return $this->hasMany('App\Models\Relation\UserToMenuItem')->get();
    }

    // Return the user full name
    public function getFullName()
    {
        if ($this->middle_name == null)
            return $this->first_name." ".$this->last_name;
        else
            return $this->first_name." ".$this->middle_name." ".$this->last_name;
    }

    // Return password reset user list
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
        return $query->where('sync_type_id', $type_id);
    }
}
