<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'address',
        'barangay',
        'latitude',
        'longitude',
        'image_path',
        'opening_hours',
        'contact_number',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
