<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UomType extends Model
{
    protected $table = 'uom_types';

    protected $fillable = [
        'name',
    ];
}
