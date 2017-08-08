<?php

namespace App\Models\Sync;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'sync_users';

    protected $fillable = [
        'user_id',
        'hierarchy_report',
        'hierarchy_column',
        'hierarchy_value',
    ];

    // Return the user
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->first();
    }
}
