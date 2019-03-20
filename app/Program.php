<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name_id', 'description_id', 
        'name_en', 'description_en', 
        'name_ar', 'description_ar', 
        'icon', 'image'
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

        return $this->description_id;
    }

    public function packages() {
        return $this->hasMany(ProgramPackage::class);
    }

    public function galleries() {
        return $this->hasMany(ProgramGallery::class);
    }
}
