<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'restaurant_types';

    protected $fillable = [
        'name',
    ];
}
