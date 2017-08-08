<?php

namespace App\Models\Smg;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'smg_types';

    protected $fillable = [
        'name',
    ];
}
