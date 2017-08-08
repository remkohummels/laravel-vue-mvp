<?php

namespace App\Models\ProductMix;

use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    protected $table = 'product_mix_modifier';

    protected $fillable = [
        'product_mix_id',
        'restaurant_id',
        'name'
    ];

}
