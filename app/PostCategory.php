<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $fillable = [
        'name', 'name_en', 'name_ar',
        'description', 'description_en', 'description_ar',
        'parent_id', 'image'
    ];
}
