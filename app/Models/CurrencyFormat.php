<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyFormat extends Model
{
    protected $table = 'currency_formats';

    protected $fillable = [
        'name',
    ];
}
