<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseLocation extends Model
{
    protected $table = 'franchise_locations';

    protected $fillable = [
        "Rest #",
        "Open Status",
        "Ownership",
        "Address",
        "City",
        "State",
        "Zip",
        "Restaurant Phone",
        "DMA #",
        "DMA Name",
        "Venue",
        "Venue: Other",
        "Franchise Entity",
        "Franchise Owner Contact",
        "Franchise Owner Contact Address",
        "Franchise Owner Contact Address 2",
        "Franchise Owner Contact Phone",
        "Franchise Owner Contact E-mail",
        "Franchise President",
        "Franchise President Phone",
        "Franchise President E-mail",
        "Franchise VP of Operations",
        "Franchise VP of Operations Phone",
        "Franchise VP of Operations E-mail",
        "Franchise Zone Director",
        "Franchise Zone Director Phone",
        "Franchise Zone Director E-mail",
        "Franchise Market Leader",
        "Franchise Market Leader Phone",
        "Franchise Market Leader E-mail",
        "Sr Regional Franchise Director",
        "Sr Regional Franchise Director E-mail",
        "Regional Franchise Director E-mail",
        "Field Marketing",
        "Field Marketing E-mail",
        "National Field Trainer",
        "National Field Trainer E-mail",
        "NFT Region",
        "Ops Excellence Coaches",
        "Ops Excellence email",
        "FRN Restaurant email",
        "POS System",
        "Media/Non Media",
        "Open Date",
        "Drive Thru Information",
        "Distribution Center",
        "Owner Base of Operations DMA",
        "Owner Base of Ops State",
        "Franchise Entity #",
        "Add'l Email Addresses",
        "Franchise Agreement Expiration Date"
    ];
}
