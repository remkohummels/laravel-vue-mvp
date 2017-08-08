<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    protected $table = 'company_locations';

    protected $fillable = [
        'Rest #',
        'Open Status',
        'Address',
        'City',
        'State',
        'Zip',
        'Phone',
        'DMA #',
        'DMA Name',
        'Zone Director',
        'ZDO Mobile Phone',
        'ZDO E-Mail',
        'Zone',
        'Zone/Region #',
        'Market Leader',
        'Market Leader Mobile Phone',
        'Market Leader E-mail',
        'Market #',
        'NFT',
        'NFT E-mail',
        'FM',
        'FM E-mail',
        'President & CEO',
        'Restaurant Email',
        'Venue',
        'Venue: Other',
        'Open Date',
        'Drive Thru Information',
        'Chicken Distribution Center',
        'Ops Excellence Coach',
        'Ops Excellence Email'
    ];
}
