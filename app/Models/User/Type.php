<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'user_types';

    protected $fillable = [
        'name',
    ];
}
