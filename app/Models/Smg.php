<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smg extends Model
{
    protected $table = 'smg';

    protected $fillable = [
        'type_id',
        'store',
        'count',
        'overall_satisfaction_score',
        'overall_satisfaction_n',
        'taste_of_food_score',
        'taste_of_food_n',
        'speed_of_service_score',
        'speed_of_service_n'
    ];

    // Return the smg type
    public function type()
    {
        return $this->hasOne('App\Models\Smg\Type', 'id', 'type_id')->first();
    }
}
