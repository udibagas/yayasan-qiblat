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
