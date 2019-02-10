<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramPackage extends Model
{
    protected $fillable = [
        'program_id', 
        'name', 'description', 
        'name_en', 'description_en', 
        'name_ar', 'description_ar', 
        'price'
    ];
}
