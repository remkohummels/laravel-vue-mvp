<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoursTemplate extends Model
{
    protected $table = 'hours_templates';

    protected $fillable = [
        'template_name',
        'sync_type_id',
        'sync_date',
    ];

    // Return the sync type
    public function syncType()
    {
        return $this->hasOne('App\Models\Sync\Type', 'id', 'sync_type_id')->first();
    }

    // Return the sync hoursTemplate list
    public function syncHoursTemplateList()
    {
        return $this->hasMany('App\Models\Sync\HoursTemplate')->get();
    }
}
