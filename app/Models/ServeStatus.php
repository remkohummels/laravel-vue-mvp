<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServeStatus extends Model
{
    protected $table = 'serve_status';

    protected $fillable = [
        'name',
    ];
}
