<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_1',
        'phone_2', 
        'address',
        'map_location',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'youtube',
        'pinterest',
        'email_support',
        'email_business',
    ];
}