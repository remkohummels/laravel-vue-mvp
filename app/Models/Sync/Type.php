<?php

namespace App\Models\Sync;

use Illuminate\Database\Eloquent\Model;

class Type extends Authenticatable
{
    protected $table = 'sync_types';

    protected $fillable = [
        'name',
    ];
}
