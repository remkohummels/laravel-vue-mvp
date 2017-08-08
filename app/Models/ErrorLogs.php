<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLogs extends Model
{
    protected $fillable = [
        'function',
        'error'
    ];

}
