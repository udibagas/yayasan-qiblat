<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'name_id', 'name_en', 'name_ar',
        'description_id', 'description_en', 'description_ar',
        'image', 'achievement'
    ];

    public function getNameAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->name_en;
        }

        if ($locale == 'ar') {
            return $this->name_ar;
        }

        return $this->name_id;
    }

    public function getDescriptionAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->description_en;
        }

        if ($locale == 'ar') {
            return $this->description_ar;
        }

        return $this->description_ar;
    }
}
