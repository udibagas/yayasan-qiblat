<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'description', 'image_path',
        'name_en', 'description_en',
        'name_ar', 'description_ar',
    ];
}
