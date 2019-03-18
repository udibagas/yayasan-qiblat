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

    public function getNameAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->name_en;
        }

        if ($locale == 'ar') {
            return $this->name_ar;
        }

        return $v;
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

        return $v;
    }

    public function packages() {
        return $this->hasMany(ProgramPackage::class);
    }

    public function galleries() {
        return $this->hasMany(ProgramGallery::class);
    }
}
