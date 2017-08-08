<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternationalLocation extends Model
{
    protected $table = 'international_locations';

    protected $fillable = [
        "Rest #",
        "Open Status",
        "Ownership",
        "International Restaurant Name",
        "Address",
        "City",
        "Country",
        "Zip",
        "Restaurant Phone",
        "Venue",
        "Venue: Other",
        "Franchise Entity",
        "Franchise Owner",
        "Franchise Owner Contact Address",
        "Franchise Owner Contact Address 2",
        "Franchise Owner Phone",
        "Franchise Owner Email",
        "Franchise Operations VP/Director",
        "Franchise Operations VP/Director Phone",
        "Franchise Operations VP/Director Email",
        "Franchise Market Leader",
        "Franchise Market Leader Phone",
        "Franchise Market Leader Email",
        "Regional Franchise Director",
        "Regional Franchise Director Email",
        "Regional Franchise Manager",
        "Regional Franchise Manager E-mail",
        "Regional Marketing",
        "Regional Marketing Email",
        "Regional Training",
        "Regional Training Email",
        "Open Date",
        "Brand",
        "SMG",
        "Asset Type",
        "Zone Director",
        "ZDO Phone",
        "ZDO Email",
        "Restaurant Email",
        "OPS Excellence Coach",
        "OPS Excellence Email",
        "Franchise Agreement Expiration Date"
    ];
}
