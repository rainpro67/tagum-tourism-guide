<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $fillable = ['name', 'slug', 'icon', 'description'];

public function places() { return $this->hasMany(Place::class); }
public function events() { return $this->hasMany(Event::class); } 
}
