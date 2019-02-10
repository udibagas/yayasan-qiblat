<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name', 'description', 
        'name_en', 'description_en', 
        'name_ar', 'description_ar', 
        'icon'
    ];
}
