<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'status',
        'title_en', 'description_en',
        'title_ar', 'description_ar'
    ];

    public function getTitleAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->title_en;
        }

        if ($locale == 'ar') {
            return $this->title_ar;
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

    protected $with = ['buttons'];

    public function buttons()
    {
        return $this->hasMany(CarouselButton::class);
    }

    public function scopeActive($q) 
    {
        return $q->where('status', 1);
    }
}
