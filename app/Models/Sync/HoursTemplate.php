<?php

namespace App\Models\Sync;

use Illuminate\Database\Eloquent\Model;

class HoursTemplate extends Model
{
    protected $table = 'sync_hours_templates';

    protected $fillable = [
        'hours_template_id',
        'hierarchy_report',
        'hierarchy_column',
        'hierarchy_value',
    ];

    // Return the menu_item
    public function hoursTemplate()
    {
        return $this->hasOne('App\Models\HoursTemplate', 'id', 'hours_template_id')->first();
    }
}
