<?php

namespace App\Models\ProductProjection;

use Illuminate\Database\Eloquent\Model;

class HoursTemplate extends Model
{
    protected $table = 'product_projection_hours_template';

    protected $fillable = [
        'template_name',
    ];
}
