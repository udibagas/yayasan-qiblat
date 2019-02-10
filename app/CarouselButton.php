<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarouselButton extends Model
{
    protected $fillable = ['carousel_id', 'label', 'label_en', 'label_ar', 'url', 'type'];
}
