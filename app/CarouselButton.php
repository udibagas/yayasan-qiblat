<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarouselButton extends Model
{
    protected $fillable = ['carousel_id', 'label_id', 'label_en', 'label_ar', 'url', 'type'];

    public function getLabelAttribute($v)
    {
        $locale = app()->getLocale();

        if ($locale == 'en') {
            return $this->label_en;
        }

        if ($locale == 'ar') {
            return $this->label_ar;
        }

        return $this->label_id;
    }
}
